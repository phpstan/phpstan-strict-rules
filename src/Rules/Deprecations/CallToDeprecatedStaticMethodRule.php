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

		$class = $node->class;

		if (!$class instanceof Name) {
			return [];
		}

		$className = (string) $class;

		try {
			$classReflection = $this->broker->getClass($className);
			$methodReflection = $classReflection->getMethod($node->name, $scope);

			if (!$methodReflection instanceof DeprecatableReflection) {
				return [];
			}

			if ($methodReflection->isDeprecated()) {
				return [sprintf(
					'Call to deprecated method %s() of class %s.',
					$methodReflection->getName(),
					$methodReflection->getDeclaringClass()->getName()
				)];
			}
		} catch (\PHPStan\Broker\ClassNotFoundException $e) {
			// Other rules will notify if the class is not found
		} catch (\PHPStan\Reflection\MissingMethodFromReflectionException $e) {
			// Other rules will notify if the the method is not found
		}

		return [];
	}

}
