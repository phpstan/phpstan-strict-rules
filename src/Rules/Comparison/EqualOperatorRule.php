<?php declare(strict_types = 1);

namespace PHPStan\Rules\Comparison;

class EqualOperatorRule implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return \PhpParser\Node\Expr\BinaryOp\Equal::class;
	}

	/**
	 * @param \PhpParser\Node\Expr\BinaryOp\Equal $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope): array
	{
		return ['Equal operator used, use identity comparison instead (===).'];
	}

}
