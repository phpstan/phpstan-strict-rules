<?php declare(strict_types = 1);

namespace PHPStan\Rules\CatchClause;

use PhpParser\Node;
use PhpParser\Node\Stmt\Catch_;
use PHPStan\Analyser\Scope;
use function is_string;
use function sprintf;

/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Catch_>
 */
class OverwriteVariablesInCatchClauseRule implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return Catch_::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		if (
			$node->var !== null
			&& is_string($node->var->name)
			&& $scope->hasVariableType($node->var->name)->yes()
		) {
			return [
				sprintf('Catch clause overwrites variable $%s.', $node->var->name),
			];
		}

		return [];
	}

}
