<?php declare(strict_types = 1);

namespace PHPStan\Rules\ForeachLoop;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt\Foreach_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use function is_string;
use function sprintf;

class OverwriteVariablesWithForeachRule implements Rule
{

	public function getNodeType(): string
	{
		return Node\Stmt\Foreach_::class;
	}

	/**
	 * @param Foreach_ $node
	 * @return string[]
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		$errors = [];
		if (
			$node->keyVar instanceof Node\Expr\Variable
			&& is_string($node->keyVar->name)
			&& $scope->hasVariableType($node->keyVar->name)->yes()
		) {
			$errors[] = sprintf('Foreach overwrites $%s with its key variable.', $node->keyVar->name);
		}

		foreach ($this->checkValueVar($scope, $node->valueVar) as $error) {
			$errors[] = $error;
		}

		return $errors;
	}

	/**
	 * @return string[]
	 */
	private function checkValueVar(Scope $scope, Expr $expr): array
	{
		$errors = [];
		if (
			$expr instanceof Node\Expr\Variable
			&& is_string($expr->name)
			&& $scope->hasVariableType($expr->name)->yes()
		) {
			$errors[] = sprintf('Foreach overwrites $%s with its value variable.', $expr->name);
		}

		if (
			$expr instanceof Node\Expr\List_
			|| $expr instanceof Node\Expr\Array_
		) {
			foreach ($expr->items as $item) {
				if ($item === null) {
					continue;
				}

				foreach ($this->checkValueVar($scope, $item->value) as $error) {
					$errors[] = $error;
				}
			}
		}

		return $errors;
	}

}
