<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;

class InstantiationOfDeprecatedClassRule implements \PHPStan\Rules\Rule
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
		return New_::class;
	}

	/**
	 * @param New_ $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (DeprecatedScopeHelper::isScopeDeprecated($scope)) {
			return [];
		}

		$referencedClasses = [];

		if ($node->class instanceof Name) {
			$referencedClasses[] = $scope->resolveName($node->class);
		} elseif ($node->class instanceof Class_) {
			$referencedClasses[] = $scope->resolveName($node->class->namespacedName);
		} else {
			$classTypeResult = $this->ruleLevelHelper->findTypeToCheck(
				$scope,
				$node->class,
				'', // We don't care about the error message
				function () {
					return true;
				}
			);

			if ($classTypeResult->getType() instanceof ErrorType) {
				return [];
			}

			$referencedClasses = $classTypeResult->getReferencedClasses();
		}

		$errors = [];

		foreach ($referencedClasses as $referencedClass) {
			try {
				$class = $this->broker->getClass($referencedClass);
			} catch (\PHPStan\Broker\ClassNotFoundException $e) {
				continue;
			}

			if (!$class->isDeprecated()) {
				continue;
			}

			$errors[] = sprintf(
				'Instantiation of deprecated class %s.',
				$referencedClass
			);
		}

		return $errors;
	}

}
