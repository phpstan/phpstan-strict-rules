<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\DeprecatableReflection;

class AccessDeprecatedPropertyRule implements \PHPStan\Rules\Rule
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
		return PropertyFetch::class;
	}

	/**
	 * @param PropertyFetch $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (!is_string($node->name)) {
			return [];
		}

		$propertyAccessedOnType = $scope->getType($node->var);
		$referencedClasses = $propertyAccessedOnType->getReferencedClasses();

		foreach ($referencedClasses as $referencedClass) {
			try {
				$classReflection = $this->broker->getClass($referencedClass);
				$propertyReflection = $classReflection->getProperty($node->name, $scope);

				if (!$propertyReflection instanceof DeprecatableReflection) {
					continue;
				}

				if ($propertyReflection->isDeprecated()) {
					return [sprintf(
						'Access to deprecated property %s of class %s.',
						$node->name,
						$propertyReflection->getDeclaringClass()->getName()
					)];
				}
			} catch (\PHPStan\Broker\ClassNotFoundException $e) {
				// Other rules will notify if the class is not found
			} catch (\PHPStan\Reflection\MissingPropertyFromReflectionException $e) {
				// Other rules will notify if the property is not found
			}
		}

		return [];
	}

}
