<?php declare(strict_types = 1);

namespace PHPStan\Rules\Classes;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<NoRedundantTraitUseRule>
 */
class NoRedundantTraitUseRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new NoRedundantTraitUseRule($this->createReflectionProvider());
	}

	public function testNoRedundantTraitUse(): void
	{
		$this->analyse([__DIR__ . '/data/no-redundant-trait-use.php'], [
			[
				'Class uses trait "BarTrait" redundantly as it is already included via trait "FooTrait".',
				24,
			],
		]);
	}

	public function testValidTraitUse(): void
	{
		$this->analyse([__DIR__ . '/data/no-redundant-trait-use-valid.php'], []);
	}

	public function testSingleTraitUse(): void
	{
		$this->analyse([__DIR__ . '/data/no-redundant-trait-use-single-trait.php'], []);
	}

	public function testTransitiveRedundantTraitUse(): void
	{
		$this->analyse([__DIR__ . '/data/no-redundant-trait-use-transitive.php'], [
			[
				'Class uses trait "BaseTrait" redundantly as it is already included via trait "WrapperTrait".',
				24,
			],
		]);
	}

}
