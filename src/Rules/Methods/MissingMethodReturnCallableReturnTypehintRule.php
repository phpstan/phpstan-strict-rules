<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\CallableType;
use PHPStan\Type\ClosureType;
use PHPStan\Type\MixedType;

/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\ClassMethod>
 */
final class MissingMethodReturnCallableReturnTypehintRule implements \PHPStan\Rules\Rule
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

		$ruleError = $this->checkMethodReturnType($methodReflection);
		if ($ruleError === null) {
			return [];
		}

		return [$ruleError];
	}

	private function checkMethodReturnType(MethodReflection $methodReflection): ?RuleError
	{
		$returnType = ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();

		if (!($returnType instanceof CallableType || $returnType instanceof ClosureType)) {
			return null;
		}

		$callableReturnType = $returnType->getReturnType();

		if ($callableReturnType instanceof MixedType && !$callableReturnType->isExplicitMixed()) {
			return RuleErrorBuilder::message(sprintf(
				'Method %s::%s() has callable return type with no return typehint specified.',
				$methodReflection->getDeclaringClass()->getName(),
				$methodReflection->getName()
			))->build();
		}

		return null;
	}

}
