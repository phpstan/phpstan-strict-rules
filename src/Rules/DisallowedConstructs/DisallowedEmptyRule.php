<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PhpParser\Node;
use PhpParser\Node\Expr\Empty_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

class DisallowedEmptyRule implements Rule
{

	public function getNodeType(): string
	{
		return Empty_::class;
	}

	/**
	 * @param Empty_ $node
	 * @return string[]
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		return [
			'Construct empty() is not allowed. Use more strict comparison.',
		];
	}

}
