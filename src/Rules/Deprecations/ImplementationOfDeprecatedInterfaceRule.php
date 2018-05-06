<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;

class ImplementationOfDeprecatedInterfaceRule implements \PHPStan\Rules\Rule
{

	/** @var Broker */
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
		$errors = [];

		$className = isset($node->namespacedName)
			? (string) $node->namespacedName
			: (string) $node->name;

		try {
			$class = $this->broker->getClass($className);
		} catch (\PHPStan\Broker\ClassNotFoundException $e) {
			return [];
		}

		if ($class->isDeprecated()) {
			return [];
		}

		foreach ($node->implements as $implement) {
			$interfaceName = (string) $implement;

			try {
				$interface = $this->broker->getClass($interfaceName);

				if ($interface->isDeprecated()) {
					if (!$class->getNativeReflection()->isAnonymous()) {
						$errors[] = sprintf(
							'Implementation of deprecated interface %s in class %s.',
							$interfaceName,
							$className
						);
					} else {
						$errors[] = sprintf(
							'Implementation of deprecated interface %s in an anonymous class.',
							$interfaceName
						);
					}
				}
			} catch (\PHPStan\Broker\ClassNotFoundException $e) {
				// Other rules will notify if the interface is not found
			}
		}

		return $errors;
	}

}
