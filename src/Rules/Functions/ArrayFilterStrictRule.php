<?php declare(strict_types = 1);

namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\ArgumentsNormalizer;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
use function count;
use function sprintf;

/**
 * @implements Rule<FuncCall>
 */
class ArrayFilterStrictRule implements Rule
{

	/** @var ReflectionProvider */
	private $reflectionProvider;

	/** @var bool */
	private $treatPhpDocTypesAsCertain;

	/** @var bool */
	private $reportMaybes;

	public function __construct(
		ReflectionProvider $reflectionProvider,
		bool $treatPhpDocTypesAsCertain,
		bool $reportMaybes
	)
	{
		$this->reflectionProvider = $reflectionProvider;
		$this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
		$this->reportMaybes = $reportMaybes;
	}

	public function getNodeType(): string
	{
		return FuncCall::class;
	}

	/**
	 * @param FuncCall $node
	 * @return list<RuleError>
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (!$node->name instanceof Name) {
			return [];
		}

		if (!$this->reflectionProvider->hasFunction($node->name, $scope)) {
			return [];
		}

		$functionReflection = $this->reflectionProvider->getFunction($node->name, $scope);

		if ($functionReflection->getName() !== 'array_filter') {
			return [];
		}

		$parametersAcceptor = ParametersAcceptorSelector::selectFromArgs(
			$scope,
			$node->getArgs(),
			$functionReflection->getVariants(),
			$functionReflection->getNamedArgumentsVariants()
		);

		$normalizedFuncCall = ArgumentsNormalizer::reorderFuncArguments($parametersAcceptor, $node);

		if ($normalizedFuncCall === null) {
			return [];
		}

		$args = $normalizedFuncCall->getArgs();
		if (count($args) === 0) {
			return [];
		}

		if (count($args) === 1) {
			return [RuleErrorBuilder::message('Call to function array_filter() requires parameter #2 to be passed to avoid loose comparison semantics.')->build()];
		}

		$nativeCallbackType = $scope->getNativeType($args[1]->value);

		if ($this->treatPhpDocTypesAsCertain) {
			$callbackType = $scope->getType($args[1]->value);
		} else {
			$callbackType = $nativeCallbackType;
		}

		if ($this->isCallbackTypeNull($callbackType)) {
			$message = 'Parameter #2 of array_filter() cannot be null to avoid loose comparison semantics (%s given).';
			$errorBuilder = RuleErrorBuilder::message(sprintf(
				$message,
				$callbackType->describe(VerbosityLevel::typeOnly())
			));

			if (!$this->isCallbackTypeNull($nativeCallbackType) && $this->treatPhpDocTypesAsCertain) {
				$errorBuilder->tip('Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.');
			}

			return [$errorBuilder->build()];
		}

		return [];
	}

	private function isCallbackTypeNull(Type $callbackType): bool
	{
		if ($callbackType->isNull()->yes()) {
			return true;
		}

		if ($callbackType->isNull()->no()) {
			return false;
		}

		return $this->reportMaybes;
	}

}
