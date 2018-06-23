<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\DeprecatableReflection;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;

class AccessDeprecatedStaticPropertyRule implements \PHPStan\Rules\Rule
{

	/** @var Broker */
	private $broker;

	/** @var RuleLevelHelper */
	private $ruleLevelHelper;

	public function __construct(Broker $broker, RuleLevelHelper $ruleLevelHelper)
	{
		$this->broker = $broker;
		$this->ruleLevelHelper = $ruleLevelHelper;
	}

	public function getNodeType(): string
	{
		return StaticPropertyFetch::class;
	}

	/**
	 * @param StaticPropertyFetch $node
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
		$referencedClasses = [];

		if ($node->class instanceof Name) {
			$referencedClasses[] = (string) $node->class;
		} else {
			$classTypeResult = $this->ruleLevelHelper->findTypeToCheck(
				$scope,
				$node->class,
				'', // We don't care about the error message
				function (Type $type) use ($propertyName) {
					return $type->canAccessProperties()->yes() && $type->hasProperty($propertyName);
				}
			);

			if ($classTypeResult->getType() instanceof ErrorType) {
				return [];
			}

			$referencedClasses = $classTypeResult->getReferencedClasses();
		}

		foreach ($referencedClasses as $referencedClass) {
			try {
				$class = $this->broker->getClass($referencedClass);
				$property = $class->getProperty($propertyName, $scope);
			} catch (\PHPStan\Broker\ClassNotFoundException $e) {
				continue;
			} catch (\PHPStan\Reflection\MissingPropertyFromReflectionException $e) {
				continue;
			}

			if ($property instanceof DeprecatableReflection && $property->isDeprecated()) {
				return [sprintf(
					'Access to deprecated static property $%s of class %s.',
					$propertyName,
					$referencedClass
				)];
			}
		}

		return [];
	}

}
