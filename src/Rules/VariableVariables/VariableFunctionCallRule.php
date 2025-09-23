<?php declare(strict_types = 1);

namespace PHPStan\Rules\VariableVariables;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<FuncCall>
 */
class VariableFunctionCallRule implements Rule
{

	public function getNodeType(): string
	{
		return FuncCall::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		if (!$node->name instanceof Node\Expr) {
			return [];
		}

		$type = $scope->getType($node->name);
		if (!$type->isString()->yes() && !$type->isArray()->yes()) {
			return [];
		}

		return [
			RuleErrorBuilder::message('Variable function call.')->identifier('function.dynamicName')->build(),
		];
	}

}
