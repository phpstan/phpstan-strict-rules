<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassMethodNode;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Rules\Rule;

/**
 * @implements Rule<InClassMethodNode>
 */
class MethodVisibilityOverrideRule implements Rule
{

	public function getNodeType(): string
	{
		return InClassMethodNode::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		$methodReflection = $scope->getFunction();
		if (!$methodReflection instanceof MethodReflection) {
			return [];
		}

		$methodName = $methodReflection->getName();
		if (strtolower($methodName) === '__construct') {
			return [];
		}

		$declaringClass = $methodReflection->getDeclaringClass();
		$parentClass = $declaringClass->getParentClass();

		if ($parentClass === false) {
			return [];
		}

		if (!$parentClass->hasNativeMethod($methodName)) {
			return [];
		}

		$parentMethodReflection = $parentClass->getNativeMethod($methodName);

		if (!$parentMethodReflection->isPrivate() && !$parentMethodReflection->isPublic() && $methodReflection->isPublic()) {
			$message = sprintf(
				'Method %s::%s() overrides visibility from protected to public',
				$declaringClass->getDisplayName(),
				$methodName,
			);
			return [$message];
		}

		return [];
	}

}
