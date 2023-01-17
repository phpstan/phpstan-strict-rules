<?php declare(strict_types = 1);

namespace PHPStan\Rules\StrictCalls;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Type\Constant\ConstantBooleanType;
use function array_key_exists;
use function sprintf;
use function strtolower;

class StrictFunctionCallsRule implements Rule
{

	/** @var int[] */
	private $functionArguments = [
		'in_array' => 2,
		'array_search' => 2,
		'base64_decode' => 1,
		'array_keys' => 2,
	];

	/** @var ReflectionProvider */
	private $reflectionProvider;

	public function __construct(ReflectionProvider $reflectionProvider)
	{
		$this->reflectionProvider = $reflectionProvider;
	}

	public function getNodeType(): string
	{
		return FuncCall::class;
	}

	/**
	 * @param FuncCall $node
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (!$node->name instanceof Name) {
			return [];
		}

		$functionName = $this->reflectionProvider->resolveFunctionName($node->name, $scope);
		if ($functionName === null) {
			return [];
		}
		$functionName = strtolower($functionName);
		if (!array_key_exists($functionName, $this->functionArguments)) {
			return [];
		}

		if ($functionName === 'array_keys' && !array_key_exists(1, $node->getArgs())) {
			return [];
		}

		$argumentPosition = $this->functionArguments[$functionName];
		if (!array_key_exists($argumentPosition, $node->getArgs())) {
			return [sprintf('Call to function %s() requires parameter #%d to be set.', $functionName, $argumentPosition + 1)];
		}

		$argumentType = $scope->getType($node->getArgs()[$argumentPosition]->value);
		$trueType = new ConstantBooleanType(true);
		if (!$trueType->isSuperTypeOf($argumentType)->yes()) {
			return [sprintf('Call to function %s() requires parameter #%d to be true.', $functionName, $argumentPosition + 1)];
		}

		return [];
	}

}
