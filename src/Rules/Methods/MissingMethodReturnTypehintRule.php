<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
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
		return \PHPStan\Node\InClassMethodNode::class;
	}

	/**
	 * @param \PHPStan\Node\InClassMethodNode $node
	 * @param \PHPStan\Analyser\Scope $scope
	 *
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (!$scope->isInClass()) {
			throw new \PHPStan\ShouldNotHappenException();
		}

		$methodReflection = $scope->getFunction();

		if (!$methodReflection instanceof MethodReflection) {
			throw new \PHPStan\ShouldNotHappenException();
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

		if ($returnType instanceof MixedType && !$returnType->isExplicitMixed()) {
			return sprintf(
				'Method %s::%s() has no return typehint specified.',
				$methodReflection->getDeclaringClass()->getDisplayName(),
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

		return sprintf(
			'Method %s::%s() has a return type %s with no value type specified.',
			$methodReflection->getDeclaringClass()->getDisplayName(),
			$methodReflection->getName(),
			$returnType->describe(VerbosityLevel::typeOnly())
		);
	}

}
