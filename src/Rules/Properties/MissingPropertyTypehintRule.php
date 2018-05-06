<?php declare(strict_types = 1);

namespace PHPStan\Rules\Properties;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Type\MixedType;

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

		$propertyReflection = $scope->getClassReflection()->getNativeProperty($node->name);

		$messages = [];

		$message = $this->checkPropertyType($node->name, $propertyReflection);
		if ($message !== null) {
			$messages[] = $message;
		}

		return $messages;
	}

	private function checkPropertyType(string $propertyName, PropertyReflection $propertyReflection): ?string
	{
		$returnType = $propertyReflection->getType();

		if ($returnType instanceof MixedType && !$returnType->isExplicitMixed()) {
			return sprintf(
				'Property %s::$%s has no typehint specified',
				$propertyReflection->getDeclaringClass()->getName(),
				$propertyName
			);
		}

		return null;
	}

}
