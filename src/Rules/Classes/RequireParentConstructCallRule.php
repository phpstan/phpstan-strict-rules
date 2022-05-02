<?php declare(strict_types = 1);

namespace PHPStan\Rules\Classes;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\BetterReflection\Reflection\Adapter\ReflectionClass;
use PHPStan\BetterReflection\Reflection\Adapter\ReflectionEnum;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;
use function property_exists;
use function sprintf;

class RequireParentConstructCallRule implements Rule
{

	public function getNodeType(): string
	{
		return ClassMethod::class;
	}

	/**
	 * @param ClassMethod $node
	 * @return string[]
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (!$scope->isInClass()) {
			throw new ShouldNotHappenException();
		}

		if ($scope->isInTrait()) {
			return [];
		}

		if ($node->name->name !== '__construct') {
			return [];
		}

		if ($node->isAbstract()) {
			return [];
		}

		$classReflection = $scope->getClassReflection()->getNativeReflection();
		if ($classReflection->isInterface() || $classReflection->isAnonymous()) {
			return [];
		}

		if ($this->callsParentConstruct($node)) {
			if ($classReflection->getParentClass() === false) {
				return [
					sprintf(
						'%s::__construct() calls parent constructor but does not extend any class.',
						$classReflection->getName()
					),
				];
			}

			if ($this->getParentConstructorClass($classReflection) === false) {
				return [
					sprintf(
						'%s::__construct() calls parent constructor but parent does not have one.',
						$classReflection->getName()
					),
				];
			}
		} else {
			$parentClass = $this->getParentConstructorClass($classReflection);
			if ($parentClass !== false) {
				return [
					sprintf(
						'%s::__construct() does not call parent constructor from %s.',
						$classReflection->getName(),
						$parentClass->getName()
					),
				];
			}
		}

		return [];
	}

	private function callsParentConstruct(Node $parserNode): bool
	{
		if (!property_exists($parserNode, 'stmts')) {
			return false;
		}

		foreach ($parserNode->stmts as $statement) {
			if ($statement instanceof Node\Stmt\Expression) {
				$statement = $statement->expr;
			}

			$statement = $this->ignoreErrorSuppression($statement);
			if ($statement instanceof StaticCall) {
				if (
					$statement->class instanceof Name
					&& ((string) $statement->class === 'parent')
					&& $statement->name instanceof Node\Identifier
					&& $statement->name->name === '__construct'
				) {
					return true;
				}
			} else {
				if ($this->callsParentConstruct($statement)) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * @param ReflectionClass|ReflectionEnum $classReflection
	 * @return ReflectionClass|false
	 */
	private function getParentConstructorClass($classReflection)
	{
		while ($classReflection->getParentClass() !== false) {
			$constructor = $classReflection->getParentClass()->hasMethod('__construct') ? $classReflection->getParentClass()->getMethod('__construct') : null;
			$constructorWithClassName = $classReflection->getParentClass()->hasMethod($classReflection->getParentClass()->getName()) ? $classReflection->getParentClass()->getMethod($classReflection->getParentClass()->getName()) : null;
			if (
				(
					$constructor !== null
					&& $constructor->getDeclaringClass()->getName() === $classReflection->getParentClass()->getName()
					&& !$constructor->isAbstract()
					&& !$constructor->isPrivate()
				) || (
					$constructorWithClassName !== null
					&& $constructorWithClassName->getDeclaringClass()->getName() === $classReflection->getParentClass()->getName()
					&& !$constructorWithClassName->isAbstract()
				)
			) {
				return $classReflection->getParentClass();
			}

			$classReflection = $classReflection->getParentClass();
		}

		return false;
	}

	private function ignoreErrorSuppression(Node $statement): Node
	{
		if ($statement instanceof Node\Expr\ErrorSuppress) {

			return $statement->expr;
		}

		return $statement;
	}

}
