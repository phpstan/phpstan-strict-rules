<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\DeprecatableReflection;
use PHPStan\Type\TypeUtils;

class AccessDeprecatedPropertyRule implements \PHPStan\Rules\Rule
{

	/** @var Broker */
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
		if (DeprecatedScopeHelper::isScopeDeprecated($scope)) {
			return [];
		}

		if (!$node->name instanceof Identifier) {
			return [];
		}

		$propertyName = $node->name->name;
		$propertyAccessedOnType = $scope->getType($node->var);
		$referencedClasses = TypeUtils::getDirectClassNames($propertyAccessedOnType);

		foreach ($referencedClasses as $referencedClass) {
			try {
				$classReflection = $this->broker->getClass($referencedClass);
				$propertyReflection = $classReflection->getProperty($propertyName, $scope);

				if (!$propertyReflection instanceof DeprecatableReflection) {
					continue;
				}

				if ($propertyReflection->isDeprecated()) {
					return [sprintf(
						'Access to deprecated property $%s of class %s.',
						$propertyName,
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
