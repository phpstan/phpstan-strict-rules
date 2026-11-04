<?php declare(strict_types = 1);

namespace PHPStan\Rules\StrictCalls;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PHPStan\Analyser\ArgumentsNormalizer;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Type;
use function array_key_exists;
use function sprintf;
use function strtolower;

/**
 * @implements Rule<FuncCall>
 */
class StrictFunctionCallsRule implements Rule
{

	/** @var int[] */
	private array $functionArguments = [
		'in_array' => 2,
		'array_search' => 2,
		'base64_decode' => 1,
		'array_keys' => 2,
	];

	private ReflectionProvider $reflectionProvider;

	public function __construct(ReflectionProvider $reflectionProvider)
	{
		$this->reflectionProvider = $reflectionProvider;
	}

	public function getNodeType(): string
	{
		return FuncCall::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		if (!$node->name instanceof Name) {
			return [];
		}

		$originalNode = $node;

		if (!$this->reflectionProvider->hasFunction($node->name, $scope)) {
			return [];
		}

		$function = $this->reflectionProvider->getFunction($node->name, $scope);
		$parametersAcceptor = ParametersAcceptorSelector::selectFromArgs($scope, $node->getArgs(), $function->getVariants());
		$node = ArgumentsNormalizer::reorderFuncArguments($parametersAcceptor, $node);
		if ($node === null) {
			return [];
		}
		$functionName = strtolower($function->getName());
		if (!array_key_exists($functionName, $this->functionArguments)) {
			return [];
		}

		if ($functionName === 'array_keys' && !array_key_exists(1, $node->getArgs())) {
			return [];
		}

		$argumentPosition = $this->functionArguments[$functionName];
		if (!array_key_exists($argumentPosition, $node->getArgs())) {
			return [
				$this->buildError(
					sprintf(
						'Call to function %s() requires parameter #%d to be set.',
						$functionName,
						$argumentPosition + 1,
					),
					$functionName,
					$originalNode,
					$node,
					$scope,
				),
			];
		}

		$argumentType = $scope->getType($node->getArgs()[$argumentPosition]->value);
		if (!$argumentType->isTrue()->yes()) {
			return [
				$this->buildError(
					sprintf(
						'Call to function %s() requires parameter #%d to be true.',
						$functionName,
						$argumentPosition + 1,
					),
					$functionName,
					$originalNode,
					$node,
					$scope,
				),
			];
		}

		return [];
	}

	private function buildError(
		string $message,
		string $functionName,
		FuncCall $originalNode,
		FuncCall $normalizedNode,
		Scope $scope
	): IdentifierRuleError
	{
		$errorBuilder = RuleErrorBuilder::message($message)->identifier('function.strict');
		if (
			($functionName === 'in_array' || $functionName === 'array_search' || $functionName === 'array_keys')
			&& $this->hasSafeStrictComparisonTypes($functionName, $normalizedNode, $scope)
		) {
			$errorBuilder->fixNode($originalNode, static function (FuncCall $call): FuncCall {
				$strictArgument = null;
				$positionalArgument = 0;
				$hasNamedArguments = false;
				foreach ($call->getArgs() as $arg) {
					if ($arg->unpack) {
						// unpack is not fixable
						return $call;
					}

					if ($arg->name !== null) {
						$hasNamedArguments = true;
						if ($arg->name->toString() === 'strict') {
							$strictArgument = $arg;
						}
						continue;
					}

					if ($positionalArgument === 2) {
						$strictArgument = $arg;
					}
					$positionalArgument++;
				}

				$true = new ConstFetch(new Name('true'));
				if ($strictArgument !== null) {
					$strictArgument->value = $true;
					return $call;
				}

				$call->args[] = new Arg(
					$true,
					false,
					false,
					[],
					$hasNamedArguments ? new Identifier('strict') : null,
				);

				return $call;
			});
		}

		return $errorBuilder->build();
	}

	private function hasSafeStrictComparisonTypes(string $functionName, FuncCall $normalizedNode, Scope $scope): bool
	{
		$args = $normalizedNode->getArgs();
		if (!isset($args[0], $args[1])) {
			return false;
		}

		$needleArgument = $functionName === 'array_keys' ? $args[1] : $args[0];
		$haystackArgument = $functionName === 'array_keys' ? $args[0] : $args[1];
		$needleType = $scope->getNativeType($needleArgument->value);
		$haystackValueType = $scope->getNativeType($haystackArgument->value)->getIterableValueType();

		return $this->areSameStrictScalarTypes($needleType, $haystackValueType);
	}

	private function areSameStrictScalarTypes(Type $needleType, Type $haystackValueType): bool
	{
		return (
			$needleType->isBoolean()->yes()
			&& $haystackValueType->isBoolean()->yes()
		) || (
			$needleType->isInteger()->yes()
			&& $haystackValueType->isInteger()->yes()
		);
	}

}
