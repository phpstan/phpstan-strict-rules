<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PhpParser\Node;
use PhpParser\Node\Expr\Empty_;
use PhpParser\Node\Expr\ShellExec;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

class DisallowedBacktickRule implements Rule
{

	public function getNodeType(): string
	{
		return ShellExec::class;
	}

	/**
	 * @param Empty_ $node
	 * @return string[]
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		return [
			'Backtick operator is not allowed. Use shell_exec() instead.',
		];
	}

}
