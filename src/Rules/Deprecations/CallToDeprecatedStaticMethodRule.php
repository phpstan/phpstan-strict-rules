<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\DeprecatableReflection;

class CallToDeprecatedStaticMethodRule implements \PHPStan\Rules\Rule
{

	/**
	 * @var Broker
	 */
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
		if (!is_string($node->name)) {
			return [];
		}

		if (!$node->class instanceof Name) {
			return [];
		}

		$className = (string) $node->class;

		if ($className === 'parent') {
			$class = $scope->getClassReflection();
			$class = $class->getParentClass();
		} else {
			try {
				$class = $this->broker->getClass($className);
			}catch (\PHPStan\Broker\ClassNotFoundException $e) {
				return [];
			}
		}

		try {
			$methodReflection = $class->getMethod($node->name, $scope);

			if (!$methodReflection instanceof DeprecatableReflection) {
				return [];
			}

			if (!$methodReflection->isDeprecated()) {
				return [];
			}
		} catch (\PHPStan\Reflection\MissingMethodFromReflectionException $e) {
			return [];
		}

		return [sprintf(
			'Call to deprecated method %s() of class %s.',
			$methodReflection->getName(),
			$methodReflection->getDeclaringClass()->getName()
		)];
	}

}
