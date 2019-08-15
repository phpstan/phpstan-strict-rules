<?php declare(strict_types = 1);

namespace PHPStan\Rules\Properties;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Type\MixedType;
use PHPStan\Type\VerbosityLevel;

final class MissingPropertyTypehintRule implements \PHPStan\Rules\Rule
{

	/**
	 * @return string Class implementing \PhpParser\Node
	 */
	public function getNodeType(): string
	{
		return \PhpParser\Node\Stmt\PropertyProperty::class;
	}

	/**
	 * @param \PhpParser\Node\Stmt\PropertyProperty $node
	 * @param \PHPStan\Analyser\Scope $scope
	 *
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (!$scope->isInClass()) {
			throw new \PHPStan\ShouldNotHappenException();
		}

		$propertyReflection = $scope->getClassReflection()->getNativeProperty($node->name->name);
		$propertyType = $propertyReflection->getReadableType();
		if ($propertyType instanceof MixedType && !$propertyType->isExplicitMixed()) {
			return [
				sprintf(
					'Property %s::$%s has no typehint specified.',
					$propertyReflection->getDeclaringClass()->getDisplayName(),
					$node->name->name
				),
			];
		}

		if ($propertyType->isIterable()->yes() && $propertyType->getIterableValueType() instanceof MixedType) {
			return [
				sprintf(
					'Property %s::$%s has a type %s but no value type specified.',
					$propertyReflection->getDeclaringClass()->getDisplayName(),
					$node->name->name,
					$propertyType->describe(VerbosityLevel::typeOnly())
				),
			];
		}

		return [];
	}

}
