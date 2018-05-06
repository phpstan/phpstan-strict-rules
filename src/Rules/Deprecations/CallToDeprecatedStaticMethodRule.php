<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Analyzer\DeprecatedScopeHelper;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\DeprecatableReflection;

class CallToDeprecatedStaticMethodRule implements \PHPStan\Rules\Rule
{

	/** @var Broker */
	private $broker;

	public function __construct(Broker $broker)
	{
		$this->broker = $broker;
	}

	public function getNodeType(): string
	{
		return StaticCall::class;
	}

	/**
	 * @param StaticCall $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (DeprecatedScopeHelper::isScopeDeprecated($scope)) {
			return [];
		}

		if (!is_string($node->name)) {
			return [];
		}

		if (!$node->class instanceof Name) {
			return [];
		}

		$className = (string) $node->class;
		$class = $this->getClassWithClassName($className, $scope);

		if ($class === null) {
			return [];
		}

		try {
			$methodReflection = $class->getMethod($node->name, $scope);
		} catch (\PHPStan\Reflection\MissingMethodFromReflectionException $e) {
			return [];
		}

		$errors = [];

		if ($class->isDeprecated()) {
			$errors[] = sprintf(
				'Call to method %s() of deprecated class %s.',
				$methodReflection->getName(),
				$methodReflection->getDeclaringClass()->getName()
			);
		}

		if ($methodReflection instanceof DeprecatableReflection && $methodReflection->isDeprecated()) {
			$errors[] = sprintf(
				'Call to deprecated method %s() of class %s.',
				$methodReflection->getName(),
				$methodReflection->getDeclaringClass()->getName()
			);
		}

		return $errors;
	}

	private function getClassWithClassName(string $className, Scope $scope): ?ClassReflection
	{
		if ($className === 'parent') {
			if (!$scope->isInClass()) {
				return null;
			}

			$class = $scope->getClassReflection();
			$class = $class->getParentClass();

			return $class !== false
				? $class
				: null;
		}

		try {
			return $this->broker->getClass($className);
		} catch (\PHPStan\Broker\ClassNotFoundException $e) {
			return null;
		}
	}

}
