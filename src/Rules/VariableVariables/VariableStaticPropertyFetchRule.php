<?php declare(strict_types = 1);

namespace PHPStan\Rules\VariableVariables;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

class VariableStaticPropertyFetchRule implements Rule
{

	public function getNodeType(): string
	{
		return Node\Expr\StaticPropertyFetch::class;
	}

	/**
	 * @param \PhpParser\Node\Expr\StaticPropertyFetch $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[]
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if ($node->name instanceof Node\VarLikeIdentifier) {
			return [];
		}

		return [
			'Variable static properties are not allowed.',
		];
	}

}
