<?php declare(strict_types = 1);

namespace PHPStan\Rules\Comparison;

class NotEqualOperatorRule implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return \PhpParser\Node\Expr\BinaryOp\NotEqual::class;
	}

	/**
	 * @param \PhpParser\Node\Expr\BinaryOp\NotEqual $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope): array
	{
		return ['Not equal operator used, use identity comparison instead (!==).'];
	}

}
