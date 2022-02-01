<?php declare(strict_types = 1);

namespace PHPStan\Rules\Cast;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class UselessCastRuleTest extends RuleTestCase
{

	/** @var bool */
	private $treatPhpDocTypesAsCertain;

	protected function getRule(): Rule
	{
		return new UselessCastRule($this->treatPhpDocTypesAsCertain);
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
					46,
				],
			]
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

}
