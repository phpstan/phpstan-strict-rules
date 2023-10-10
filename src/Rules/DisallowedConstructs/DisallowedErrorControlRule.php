<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PhpParser\Node;
use PhpParser\Node\Expr\ErrorSuppress;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ErrorSuppress>
 */
class DisallowedErrorControlRule implements Rule
{

	public function getNodeType(): string
	{
		return ErrorSuppress::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		return [
			RuleErrorBuilder::message('Error control operator (`@`) is not allowed.')
				->identifier('errorControl.notAllowed')
				->build(),
		];
	}

}
