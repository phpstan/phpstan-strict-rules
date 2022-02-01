<?php declare(strict_types = 1);

namespace PHPStan\Rules\VariableVariables;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use function is_string;

class VariableVariablesRule implements Rule
{

	public function getNodeType(): string
	{
		return Node\Expr\Variable::class;
	}

	/**
	 * @param Variable $node
	 * @return string[]
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (is_string($node->name)) {
			return [];
		}

		return [
			'Variable variables are not allowed.',
		];
	}

}
