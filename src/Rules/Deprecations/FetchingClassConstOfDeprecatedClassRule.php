<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\DeprecatableReflection;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;

class FetchingClassConstOfDeprecatedClassRule implements \PHPStan\Rules\Rule
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
		return ClassConstFetch::class;
	}

	/**
	 * @param ClassConstFetch $node
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

		$constantName = $node->name->name;
		$referencedClasses = [];

		if ($node->class instanceof Name) {
			$referencedClasses[] = $scope->resolveName($node->class);
		} else {
			$classTypeResult = $this->ruleLevelHelper->findTypeToCheck(
				$scope,
				$node->class,
				'', // We don't care about the error message
				function (Type $type) use ($constantName) {
					return $type->canAccessConstants()->yes() && $type->hasConstant($constantName);
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

			if ($class->isDeprecated()) {
				$errors[] = sprintf(
					'Fetching class constant %s of deprecated class %s.',
					$constantName,
					$referencedClass
				);
			}

			if (!$class->hasConstant($constantName)) {
				continue;
			}

			$constantReflection = $class->getConstant($constantName);

			if (!$constantReflection instanceof DeprecatableReflection || !$constantReflection->isDeprecated()) {
				continue;
			}

			$errors[] = sprintf(
				'Fetching deprecated class constant %s of class %s.',
				$constantName,
				$referencedClass
			);
		}

		return $errors;
	}

}
