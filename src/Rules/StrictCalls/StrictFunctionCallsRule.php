<?php declare(strict_types = 1);

namespace PHPStan\Rules\StrictCalls;

class StrictFunctionCallsRule implements \PHPStan\Rules\Rule
{

	/** @var int[] */
	private $functionArguments = [
		'in_array' => 2,
		'array_search' => 2,
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
		$message = sprintf('Call to function %s() requires parameter #%d to be true.', $functionName, $argumentPosition + 1);
		if (!array_key_exists($argumentPosition, $node->args)) {
			return [$message];
		}

		$argumentType = $scope->getType($node->args[$argumentPosition]->value);
		if (!$argumentType instanceof \PHPStan\Type\TrueBooleanType) {
			return [$message];
		}

		return [];
	}

}
