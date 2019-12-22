<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\CallableType;
use PHPStan\Type\ClosureType;
use PHPStan\Type\MixedType;

/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\ClassMethod>
 */
final class MissingMethodParameterCallableReturnTypehintRule implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return \PhpParser\Node\Stmt\ClassMethod::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		if (!$scope->isInClass()) {
			throw new \PHPStan\ShouldNotHappenException();
		}

		$methodReflection = $scope->getClassReflection()->getNativeMethod($node->name->name);

		$ruleErrors = [];

		foreach (ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getParameters() as $parameterReflection) {
			$ruleError = $this->checkMethodParameter($methodReflection, $parameterReflection);
			if ($ruleError === null) {
				continue;
			}

			$ruleErrors[] = $ruleError;
		}

		return $ruleErrors;
	}

	private function checkMethodParameter(MethodReflection $methodReflection, ParameterReflection $parameterReflection): ?RuleError
	{
		$parameterType = $parameterReflection->getType();

		if (!($parameterType instanceof CallableType || $parameterType instanceof ClosureType)) {
			return null;
		}

		$callableReturnType = $parameterType->getReturnType();

		if ($callableReturnType instanceof MixedType && !$callableReturnType->isExplicitMixed()) {
			return RuleErrorBuilder::message(sprintf(
				'Method %s::%s() has callable parameter $%s with no return typehint specified.',
				$methodReflection->getDeclaringClass()->getDisplayName(),
				$methodReflection->getName(),
				$parameterReflection->getName()
			))->build();
		}

		return null;
	}

}
