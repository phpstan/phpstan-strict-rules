<?php declare(strict_types = 1);

namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use function count;
use function in_array;
use function strtolower;

/** @implements Rule<FuncCall> */
class UnserializeAllowedClassesRule implements Rule
{

	public function getNodeType(): string
	{
		return FuncCall::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		if (!$node->name instanceof Node\Name) {
			return [];
		}

		if (!in_array(strtolower((string) $node->name), ['unserialize'], true)) {
			return [];
		}

		$args = $node->getArgs();

		if (count($args) < 2) {
			return [
				RuleErrorBuilder::message(
					'unserialize() called without the $options argument. Always pass '
					. "['allowed_classes' => false] or an explicit list of safe classes. "
					. "If you truly need to allow all classes, pass ['allowed_classes' => true] "
					. 'to make that decision explicit.',
				)
					->identifier('unserialize.allowedClasses')
					->build(),
			];
		}

		$optionsArg = $args[1]->value;

		if (!$optionsArg instanceof Node\Expr\Array_) {
			return [];
		}

		foreach ($optionsArg->items as $item) {
			if ($item === null) {
				continue;
			}

			$key = $item->key;
			if (!$key instanceof Node\Scalar\String_) {
				continue;
			}

			if ($key->value === 'allowed_classes') {
				return [];
			}
		}

		return [
			RuleErrorBuilder::message(
				"unserialize() called without the 'allowed_classes' key in \$options. "
				. "Always pass ['allowed_classes' => false] or an explicit list of safe classes. "
				. "If you truly need to allow all classes, pass ['allowed_classes' => true] "
				. 'to make that decision explicit.',
			)
				->identifier('unserialize.allowedClasses')
				->build(),
		];
	}

}
