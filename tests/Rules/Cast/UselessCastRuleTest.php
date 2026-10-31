<?php declare(strict_types = 1);

namespace PHPStan\Rules\Cast;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<UselessCastRule>
 */
class UselessCastRuleTest extends RuleTestCase
{

	private bool $treatPhpDocTypesAsCertain;

	private bool $treatPhpDocTypesAsCertainTip = true;

	protected function getRule(): Rule
	{
		return new UselessCastRule(
			$this->treatPhpDocTypesAsCertain,
			$this->treatPhpDocTypesAsCertainTip,
		);
	}

	protected function shouldTreatPhpDocTypesAsCertain(): bool
	{
		return $this->treatPhpDocTypesAsCertain;
	}

	public function testUselessCast(): void
	{
		require_once __DIR__ . '/data/useless-cast.php';
		$this->treatPhpDocTypesAsCertain = true;
		$this->analyse(
			[__DIR__ . '/data/useless-cast.php'],
			[
				[
					'Casting to int something that\'s already int.',
					7,
				],
				[
					'Casting to string something that\'s already string.',
					9,
				],
				[
					'Casting to stdClass something that\'s already stdClass.',
					10,
				],
				[
					'Casting to float something that\'s already float.',
					27,
				],
				[
					'Casting to string something that\'s already string.',
					39,
				],
				[
					'Casting to string something that\'s already string.',
					46,
					'Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.',
				],
			],
		);
	}

	public function testDoNotReportPhpDoc(): void
	{
		$this->treatPhpDocTypesAsCertain = false;
		$this->analyse([__DIR__ . '/data/useless-cast-not-phpdoc.php'], [
			[
				'Casting to int something that\'s already int.',
				16,
			],
		]);
	}

	public function testReportPhpDoc(): void
	{
		$this->treatPhpDocTypesAsCertain = true;
		$this->analyse([__DIR__ . '/data/useless-cast-not-phpdoc.php'], [
			[
				'Casting to int something that\'s already int.',
				16,
			],
			[
				'Casting to int something that\'s already int.',
				17,
				'Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.',
			],
		]);
	}

	public function testBug14565(): void
	{
		$this->treatPhpDocTypesAsCertain = true;
		$this->analyse([__DIR__ . '/data/bug-14565.php'], []);
	}

	/**
	 * @return iterable<array{bool, bool}>
	 */
	public function dataFix(): iterable
	{
		yield [true, true];
		yield [true, false];
		yield [false, true];
		yield [false, false];
	}

	/**
	 * @dataProvider dataFix
	 */
	public function testFix(bool $treatPhpDocTypesAsCertain, bool $treatPhpDocTypesAsCertainTip): void
	{
		$this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
		$this->treatPhpDocTypesAsCertainTip = $treatPhpDocTypesAsCertainTip;
		$this->fix(__DIR__ . '/data/useless-cast-fixable.php', __DIR__ . '/data/useless-cast-fixable.php.fixed');
	}

}
