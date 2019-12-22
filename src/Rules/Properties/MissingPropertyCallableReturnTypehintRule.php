<?php declare(strict_types = 1);

namespace PHPStan\Rules\Properties;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Type\CallableType;
use PHPStan\Type\ClosureType;
use PHPStan\Type\MixedType;

/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\PropertyProperty>
 */
final class MissingPropertyCallableReturnTypehintRule implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return \PhpParser\Node\Stmt\PropertyProperty::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		if (!$scope->isInClass()) {
			throw new \PHPStan\ShouldNotHappenException();
		}

		$propertyReflection = $scope->getClassReflection()->getNativeProperty($node->name->name);
		$propertyType = $propertyReflection->getReadableType();

		if (!($propertyType instanceof CallableType || $propertyType instanceof ClosureType)) {
			return [];
		}

		$callableReturnType = $propertyType->getReturnType();

		if ($callableReturnType instanceof MixedType && !$callableReturnType->isExplicitMixed()) {
			return [
				sprintf(
					'Callable property %s::$%s has no return typehint specified.',
					$propertyReflection->getDeclaringClass()->getDisplayName(),
					$node->name->name
				),
			];
		}

		return [];
	}

}
