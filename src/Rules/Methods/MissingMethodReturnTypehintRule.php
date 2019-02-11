<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\Php\PhpMethodReflection;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;

final class MissingMethodReturnTypehintRule implements \PHPStan\Rules\Rule
{

	/**
	 * @return string Class implementing \PhpParser\Node
	 */
	public function getNodeType(): string
	{
		return \PhpParser\Node\Stmt\ClassMethod::class;
	}

	/**
	 * @param \PhpParser\Node\Stmt\ClassMethod $node
	 * @param \PHPStan\Analyser\Scope $scope
	 *
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (!$scope->isInClass()) {
			throw new \PHPStan\ShouldNotHappenException();
		}

		if (!$scope->isInTrait()) {
			$methodReflection = $scope->getClassReflection()->getNativeMethod($node->name->name);
		} else {
			$methodReflection = $scope->getTraitReflection()->getNativeMethod($node->name->name);
		}

		$messages = [];

		$message = $this->checkMethodReturnType($methodReflection);
		if ($message !== null) {
			$messages[] = $message;
		}

		return $messages;
	}

	private function checkMethodReturnType(MethodReflection $methodReflection): ?string
	{
		$returnType = ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();

		if ($methodReflection instanceof PhpMethodReflection && $methodReflection->getDeclaringTrait()) {
			$class = $methodReflection->getDeclaringTrait() ?? $methodReflection->getDeclaringClass();
		} else {
			$class = $methodReflection->getDeclaringClass();
		}

		if ($returnType instanceof MixedType && !$returnType->isExplicitMixed()) {
			return sprintf(
				'Method %s::%s() has no return typehint specified.',
				$class->getDisplayName(),
				$methodReflection->getName()
			);
		}

		if ($returnType->isIterable()->yes()) {
			return $this->checkMethodIterableReturnType($methodReflection, $returnType);
		}

		return null;
	}


	private function checkMethodIterableReturnType(MethodReflection $methodReflection, Type $returnType): ?string
	{
		$valueType = $returnType->getIterableValueType();

		if (!$valueType instanceof MixedType) {
			return null;
		}

		if ($methodReflection instanceof PhpMethodReflection && $methodReflection->getDeclaringTrait()) {
			$class = $methodReflection->getDeclaringTrait() ?? $methodReflection->getDeclaringClass();
		} else {
			$class = $methodReflection->getDeclaringClass();
		}

		return sprintf(
			'Method %s::%s() has a return type %s with no value type specified.',
			$class->getDisplayName(),
			$methodReflection->getName(),
			$returnType->describe(VerbosityLevel::typeOnly())
		);
	}

}
