<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\Php\PhpMethodReflection;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;

final class MissingMethodIterableReturnTypehintRule implements \PHPStan\Rules\Rule
{

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

		if ($returnType->isIterable()->no() || $returnType instanceof MixedType || ($returnType instanceof ObjectType && !$returnType->isIterable()->yes())) {
			return null;
		}

		$valueType = $returnType->getIterableValueType();

		if (!$valueType instanceof MixedType) {
			return null;
		}

		if ($methodReflection instanceof PhpMethodReflection && $methodReflection->getDeclaringTrait()) {
			$class = $methodReflection->getDeclaringTrait() ?? $methodReflection->getDeclaringClass();
		} else {
			$class = $methodReflection->getDeclaringClass();
		}

		if ($returnType instanceof UnionType) {
			foreach ($returnType->getTypes() as $type) {
				if (!$type->isIterable()->no() && $type->getIterableValueType() instanceof MixedType) {
					$returnType = $type;
					break;
				}
			}

			if ($returnType instanceof UnionType) {
				return null;
			}
		}

		return sprintf(
			'Method %s::%s() has a return type %s with no value type specified.',
			$class->getDisplayName(),
			$methodReflection->getName(),
			$returnType->describe(VerbosityLevel::typeOnly())
		);
	}

}
