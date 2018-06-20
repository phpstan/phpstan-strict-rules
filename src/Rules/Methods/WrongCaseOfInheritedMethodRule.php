<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;

class WrongCaseOfInheritedMethodRule implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return \PhpParser\Node\Stmt\ClassMethod::class;
	}

	/**
	 * @param \PhpParser\Node\Stmt\ClassMethod $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[]
	 */
	public function processNode(
		\PhpParser\Node $node,
		Scope $scope
	): array
	{
		if (!$scope->isInClass()) {
			throw new \PHPStan\ShouldNotHappenException();
		}

		$methodReflection = $scope->getClassReflection()->getNativeMethod($node->name->name);
		$declaringClass = $methodReflection->getDeclaringClass();

		$messages = [];
		if ($declaringClass->getParentClass() !== false) {
			$parentMessage = $this->findMethod(
				$declaringClass,
				$declaringClass->getParentClass(),
				$node->name->name
			);
			if ($parentMessage !== null) {
				$messages[] = $parentMessage;
			}
		}

		foreach ($declaringClass->getInterfaces() as $interface) {
			$interfaceMessage = $this->findMethod(
				$declaringClass,
				$interface,
				$node->name->name
			);
			if ($interfaceMessage === null) {
				continue;
			}

			/** @var string $interfaceMessage */
			$interfaceMessage = $interfaceMessage;

			$messages[] = $interfaceMessage;
		}

		return $messages;
	}

	private function findMethod(
		ClassReflection $declaringClass,
		ClassReflection $classReflection,
		string $methodName
	): ?string
	{
		if (!$classReflection->hasNativeMethod($methodName)) {
			return null;
		}

		$parentMethod = $classReflection->getNativeMethod($methodName);
		if ($parentMethod->getName() === $methodName) {
			return null;
		}

		return sprintf(
			'Method %s::%s() does not match %s method name: %s::%s().',
			$declaringClass->getDisplayName(),
			$methodName,
			$classReflection->isInterface() ? 'interface' : 'parent',
			$classReflection->getDisplayName(),
			$parentMethod->getName()
		);
	}

}
