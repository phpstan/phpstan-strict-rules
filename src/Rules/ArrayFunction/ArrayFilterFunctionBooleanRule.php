<?php declare(strict_types = 1);

namespace PHPStan\Rules\ArrayFunction;

class ArrayFilterFunctionBooleanRule implements \PHPStan\Rules\Rule
{

	/** @var int[] */
	private $functionArguments = [
		'array_filter' => 1,
	];

	/** @var \PHPStan\Broker\Broker */
	private $broker;

	public function __construct(\PHPStan\Broker\Broker $broker)
	{
		$this->broker = $broker;
	}

	public function getNodeType(): string
	{
		return \PhpParser\Node\Expr\FuncCall::class;
	}

	/**
	 * @param \PhpParser\Node\Expr\FuncCall $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope): array
	{
		if (!$node->name instanceof \PhpParser\Node\Name) {
			return [];
		}

		$functionName = $this->broker->resolveFunctionName($node->name, $scope);
		if ($functionName === null) {
			return [];
		}

		$functionName = strtolower($functionName);
		if (!array_key_exists($functionName, $this->functionArguments)) {
			return [];
		}

		$argumentPosition = $this->functionArguments[$functionName];
		$message = sprintf('Call to function %s() requires parameter #%d to be callable.', $functionName, $argumentPosition + 1);
		if (!array_key_exists($argumentPosition, $node->args)) {
			return [$message];
		}

		if ($node->args[$argumentPosition]->value instanceof \PhpParser\Node\Expr\Array_) {
			$this->getMethodFromArray($node->args[$argumentPosition]->value->items, $scope);
		}

		$message = sprintf('Call to function %s() requires parameter #%d to be callable.', $functionName, $argumentPosition + 1);
		if (!$argumentType->isCallable()) {
			return [$message];
		}

		$returnType = $scope->getFunctionType($node->args[$argumentPosition]->value->getReturnType(), false, false);
		$message = sprintf('Call to function %s() requires parameter #%d to return boolean.', $functionName, $argumentPosition + 1);
		if (!$returnType instanceof \PHPStan\Type\BooleanType) {
			return [$message];
		}

		return [];
	}

}
