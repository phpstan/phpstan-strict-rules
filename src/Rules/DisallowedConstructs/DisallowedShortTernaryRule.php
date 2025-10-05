<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PhpParser\Node;
use PhpParser\Node\Expr\Ternary;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\StaticTypeFactory;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

/**
 * @implements Rule<Ternary>
 */
class DisallowedShortTernaryRule implements Rule
{

	public function getNodeType(): string
	{
		return Ternary::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		if ($node->if !== null) {
			return [];
		}

		if ($scope->getType($node->cond)->isSuperTypeOf($this->getNonBooleanFalseyType())->no()) {
			return [];
		}

		return [
			RuleErrorBuilder::message('Short ternary operator is not allowed. Use null coalesce operator if applicable or consider using long ternary.')
				->identifier('ternary.shortNotAllowed')
				->build(),
		];
	}

	private function getNonBooleanFalseyType(): Type
	{
		static $falseyWithoutFalse;

		if ($falseyWithoutFalse === null) {
			$falseyWithoutFalse = TypeCombinator::remove(
				StaticTypeFactory::falsey(),
				new ConstantBooleanType(false),
			);
		}

		return $falseyWithoutFalse;
	}

}
