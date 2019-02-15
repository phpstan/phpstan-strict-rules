<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;

final class MissingMethodParameterTypehintRule implements \PHPStan\Rules\Rule
{

	/**
	 * @return string Class implementing \PhpParser\Node
	 */
	public function getNodeType(): string
	{
		return \PHPStan\Node\InClassMethodNode::class;
	}

	/**
	 * @param \PhpParser\Node\Stmt\ClassMethod $node
	 * @param \PHPStan\Analyser\Scope $scope
	 *
	 * @return string[] errors
	 */
	public function processNode(
		Node $node,
		Scope $scope
	): array
	{
		if (!$scope->isInClass()) {
			throw new \PHPStan\ShouldNotHappenException();
		}

		$methodReflection = $scope->getFunction();

		if (!$methodReflection instanceof MethodReflection) {
			throw new \PHPStan\ShouldNotHappenException();
		}

		$messages = [];

		foreach (ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getParameters() as $parameterReflection) {
			$message = $this->checkMethodParameter(
				$methodReflection,
				$parameterReflection
			);
			if ($message === null) {
				continue;
			}

			$messages[] = $message;
		}

		return $messages;
	}

	private function checkMethodParameter(
		MethodReflection $methodReflection,
		ParameterReflection $parameterReflection
	): ?string
	{
		$parameterType = $parameterReflection->getType();

		if ($parameterType instanceof MixedType && !$parameterType->isExplicitMixed()) {
			return sprintf(
				'Method %s::%s() has parameter $%s with no typehint specified.',
				$methodReflection->getDeclaringClass()->getDisplayName(),
				$methodReflection->getName(),
				$parameterReflection->getName()
			);
		}

		if ($parameterType->isIterable()->yes()) {
			return $this->checkMethodIterableParameter(
				$methodReflection,
				$parameterReflection,
				$parameterType
			);
		}

		return null;
	}

	private function checkMethodIterableParameter(
		MethodReflection $methodReflection,
		ParameterReflection $parameterReflection,
		Type $parameterType
	): ?string
	{
		$valueType = $parameterType->getIterableValueType();

		if (!$valueType instanceof MixedType) {
			return null;
		}

		return sprintf(
			'Method %s::%s() has parameter $%s with a type %s but no value type specified.',
			$methodReflection->getDeclaringClass()->getDisplayName(),
			$methodReflection->getName(),
			$parameterReflection->getName(),
			$parameterType->describe(VerbosityLevel::typeOnly())
		);
	}

}
