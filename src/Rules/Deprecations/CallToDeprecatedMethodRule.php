<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\DeprecatableReflection;

class CallToDeprecatedMethodRule implements \PHPStan\Rules\Rule
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
		return MethodCall::class;
	}

	/**
	 * @param MethodCall $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (!is_string($node->name)) {
			return [];
		}

		$methodCalledOnType = $scope->getType($node->var);
		$referencedClasses = $methodCalledOnType->getReferencedClasses();

		foreach ($referencedClasses as $referencedClass) {
			try {
				$classReflection = $this->broker->getClass($referencedClass);
				$methodReflection = $classReflection->getMethod($node->name, $scope);

				if (!$methodReflection instanceof DeprecatableReflection) {
					continue;
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
		}

		return [];
	}

}
