<?php declare(strict_types = 1);

namespace PHPStan\Rules\Functions;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ArrayFilterStrictRule>
 */
class ArrayFilterStrictRuleTest extends RuleTestCase
{

	/** @var bool */
	private $treatPhpDocTypesAsCertain;

	/** @var bool */
	private $checkNullables;

	protected function getRule(): Rule
	{
		return new ArrayFilterStrictRule(
			$this->createReflectionProvider(),
			$this->treatPhpDocTypesAsCertain,
			$this->checkNullables,
			true
		);
	}

	protected function shouldTreatPhpDocTypesAsCertain(): bool
	{
		return $this->treatPhpDocTypesAsCertain;
	}

	public function testRule(): void
	{
		$this->treatPhpDocTypesAsCertain = true;
		$this->checkNullables = true;
		$this->analyse([__DIR__ . '/data/array-filter-strict.php'], [
			[
				'Call to function array_filter() requires parameter #2 to be passed to avoid loose comparison semantics.',
				15,
			],
			[
				'Call to function array_filter() requires parameter #2 to be passed to avoid loose comparison semantics.',
				25,
			],
			[
				'Call to function array_filter() requires parameter #2 to be passed to avoid loose comparison semantics.',
				26,
			],
			[
				'Parameter #2 of array_filter() cannot be null to avoid loose comparison semantics (null given).',
				28,
			],
			[
				'Parameter #2 of array_filter() cannot be null to avoid loose comparison semantics ((Closure)|null given).',
				34,
			],
		]);
	}

	public function testRuleAllowMissingCallbackInSomeCases(): void
	{
		$this->treatPhpDocTypesAsCertain = true;
		$this->checkNullables = true;
		$this->analyse([__DIR__ . '/data/array-filter-allow.php'], [
			[
				'Call to function array_filter() requires parameter #2 to be passed to avoid loose comparison semantics.',
				27,
			],
			[
				'Call to function array_filter() requires parameter #2 to be passed to avoid loose comparison semantics.',
				37,
			],
			[
				'Call to function array_filter() requires parameter #2 to be passed to avoid loose comparison semantics.',
				49,
			],
		]);
	}

}
