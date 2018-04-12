<?php declare(strict_types = 1);

namespace PHPStan\Rules\StrictCalls;

use PHPStan\Type\Constant\ConstantBooleanType;

class StrictFunctionCallsRule implements \PHPStan\Rules\Rule
{

	/** @var array<string, array> */
	private $functionArguments = [
		'in_array' => [2, true],
		'array_search' => [2, true],
		'base64_decode' => [1, true],
		'array_keys' => [2, true],
		'iterator_to_array' => [1, false],
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

		if ($functionName === 'array_keys' && !array_key_exists(1, $node->args)) {
			return [];
		}

		$argumentPosition = $this->functionArguments[$functionName][0];
		if (!array_key_exists($argumentPosition, $node->args)) {
			return [sprintf('Call to function %s() requires parameter #%d to be set.', $functionName, $argumentPosition + 1)];
		}

		$argumentType = $scope->getType($node->args[$argumentPosition]->value);
		$strictType = new ConstantBooleanType((bool) $this->functionArguments[$functionName][1]);
		if (!$strictType->isSuperTypeOf($argumentType)->yes()) {
			return [sprintf('Call to function %s() requires parameter #%d to be %s.', $functionName, $argumentPosition + 1, (bool) $this->functionArguments[$functionName][1] ? 'true' : 'false')];
		}

		return [];
	}

}
