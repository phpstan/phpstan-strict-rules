<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;

class InheritanceOfDeprecatedClassRule implements \PHPStan\Rules\Rule
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
		return Class_::class;
	}

	/**
	 * @param Class_ $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if ($node->extends === null) {
			return [];
		}

		$errors = [];

		$className = isset($node->namespacedName)
			? (string) $node->namespacedName
			: (string) $node->name;

		try {
			$class = $this->broker->getClass($className);
		} catch (\PHPStan\Broker\ClassNotFoundException $e) {
			return [];
		}

		$parentClassName = (string) $node->extends;

		try {
			$parentClass = $this->broker->getClass($parentClassName);

			if ($parentClass->isDeprecated()) {
				if (!$class->getNativeReflection()->isAnonymous()) {
					$errors[] = sprintf(
						'Inheritance of deprecated class %s in class %s.',
						$parentClassName,
						$className
					);
				} else {
					$errors[] = sprintf(
						'Inheritance of deprecated class %s in an anonymous class.',
						$parentClassName
					);
				}
			}
		} catch (\PHPStan\Broker\ClassNotFoundException $e) {
			// Other rules will notify if the interface is not found
		}

		return $errors;
	}

}
