<?php declare(strict_types = 1);

namespace PHPStan\Rules\Classes;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\TraitUse;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use Throwable;
use function array_filter;
use function array_merge;
use function array_unique;
use function basename;
use function count;
use function in_array;
use function sprintf;
use function str_replace;

/**
 * Disallows redundant trait usage when a trait is already included via another trait.
 *
 * This rule checks classes that use multiple traits and ensures that
 * they don't use a trait that is already being used by another trait.
 * For example, if trait A uses trait B, then a class shouldn't use both A and B.
 *
 * @implements Rule<Class_>
 */
class NoRedundantTraitUseRule implements Rule
{

	private const ERROR_MESSAGE = 'Class uses trait "%s" redundantly as it is already included via trait "%s".';

	private ReflectionProvider $reflectionProvider;

	public function __construct(ReflectionProvider $reflectionProvider)
	{
		$this->reflectionProvider = $reflectionProvider;
	}

	public function getNodeType(): string
	{
		return Class_::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		$errors = [];

		// Get all trait use statements from the class.
		$traitUseNodes = array_filter($node->stmts, static fn ($stmt): bool => $stmt instanceof TraitUse);

		if (count($traitUseNodes) < 2) {
			// Need at least 2 traits to have redundancy.
			return [];
		}

		// Collect all directly used trait names with their resolved names.
		$directlyUsedTraits = [];
		foreach ($traitUseNodes as $traitUseNode) {
			foreach ($traitUseNode->traits as $trait) {
				$traitName = $scope->resolveName($trait);
				$directlyUsedTraits[] = $traitName;
			}
		}

		// Build a map of trait -> [traits it uses] with full resolution.
		$traitDependencies = [];
		foreach ($directlyUsedTraits as $traitName) {
			try {
				if ($this->reflectionProvider->hasClass($traitName)) {
					$traitReflection = $this->reflectionProvider->getClass($traitName);
					if ($traitReflection->isTrait()) {
						$traitDependencies[$traitName] = $this->getAllTraitsUsedByTrait($traitName, []);
					}
				}
			} catch (Throwable $e) {
				// Skip traits that can't be reflected.
				continue;
			}
		}

		// Check for redundancies.
		foreach ($directlyUsedTraits as $traitA) {
			foreach ($directlyUsedTraits as $traitB) {
				if ($traitA === $traitB) {
					continue;
				}

				// Check if traitA uses traitB (directly or transitively).
				if (isset($traitDependencies[$traitA]) && in_array($traitB, $traitDependencies[$traitA], true)) {
					$shortNameA = basename(str_replace('\\', '/', $traitA));
					$shortNameB = basename(str_replace('\\', '/', $traitB));

					$errors[] = RuleErrorBuilder::message(sprintf(self::ERROR_MESSAGE, $shortNameB, $shortNameA))
						->line($node->getStartLine())
						->identifier('traits.redundantTraitUse')
						->build();

					// Only report each redundant trait once
					break;
				}
			}
		}

		return $errors;
	}

	/**
	 * Get all traits used by a given trait recursively.
	 *
	 * @param string $traitName The fully qualified trait name.
	 * @param array<string> $visited Array to track visited traits (for cycle detection).
	 *
	 * @return array<string> Array of all trait names used by the given trait (directly and transitively).
	 */
	private function getAllTraitsUsedByTrait(string $traitName, array $visited = []): array
	{
		// Prevent infinite loops.
		if (in_array($traitName, $visited, true)) {
			return [];
		}

		$visited[] = $traitName;

		try {
			if (!$this->reflectionProvider->hasClass($traitName)) {
				return [];
			}

			$traitReflection = $this->reflectionProvider->getClass($traitName);
			if (!$traitReflection->isTrait()) {
				return [];
			}

			$allTraits = [];

			// Get direct traits used by this trait.
			foreach ($traitReflection->getTraits() as $trait) {
				$usedTraitName = $trait->getName();
				$allTraits[] = $usedTraitName;

				// Recursively get traits used by the used trait.
				$nestedTraits = $this->getAllTraitsUsedByTrait($usedTraitName, $visited);
				$allTraits = array_merge($allTraits, $nestedTraits);
			}

			return array_unique($allTraits);
		} catch (Throwable $e) {
			return [];
		}
	}

}
