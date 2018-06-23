<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PhpParser\Node;
use PhpParser\Node\Stmt\TraitUse;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;

class UsageOfDeprecatedTraitRule implements \PHPStan\Rules\Rule
{

	/** @var Broker */
	private $broker;

	public function __construct(Broker $broker)
	{
		$this->broker = $broker;
	}

	public function getNodeType(): string
	{
		return TraitUse::class;
	}

	/**
	 * @param TraitUse $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (DeprecatedScopeHelper::isScopeDeprecated($scope)) {
			return [];
		}

		$classReflection = $scope->getClassReflection();
		if ($classReflection === null) {
			throw new \PHPStan\ShouldNotHappenException();
		}

		$errors = [];
		$className = $classReflection->getName();

		foreach ($node->traits as $traitNameNode) {
			$traitName = (string) $traitNameNode;

			try {
				$trait = $this->broker->getClass($traitName);

				if ($trait->isDeprecated()) {
					$errors[] = sprintf(
						'Usage of deprecated trait %s in class %s.',
						$traitName,
						$className
					);
				}
			} catch (\PHPStan\Broker\ClassNotFoundException $e) {
				continue;
			}
		}

		return $errors;
	}

}
