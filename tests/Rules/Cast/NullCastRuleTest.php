<?php declare(strict_types = 1);

namespace PHPStan\Rules\Cast;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<NullCastRule>
 */
class NullCastRuleTest extends RuleTestCase
{

	/** @var bool */
	private $treatPhpDocTypesAsCertain;

	protected function getRule(): Rule
	{
		return new NullCastRule($this->treatPhpDocTypesAsCertain);
	}

	protected function shouldTreatPhpDocTypesAsCertain(): bool
	{
		return $this->treatPhpDocTypesAsCertain;
	}

	public function testNullCast(): void
	{
		require_once __DIR__ . '/data/null-cast.php';
		$this->treatPhpDocTypesAsCertain = true;
		$this->analyse(
			[__DIR__ . '/data/null-cast.php'],
			[
				[
					'Only non-null values should be cast to int, int|null given.',
					6,
				],
				[
					'Only non-null values should be cast to int, string|null given.',
					8,
				],
				[
					'Only non-null values should be cast to float, int|null given.',
					9,
				],
				[
					'Only non-null values should be cast to float, string|null given.',
					11,
				],
				[
					'Only non-null values should be cast to string, string|null given.',
					12,
				],
				[
					'Only non-null values should be cast to stdClass, string|null given.',
					13,
				],
				[
					'Only non-null values should be cast to stdClass, null given.',
					15,
				],
				[
					'Only non-null values should be cast to array, null given.',
					17,
				],
			]
		);
	}

	public function testDoNotReportPhpDoc(): void
	{
		$this->treatPhpDocTypesAsCertain = false;
		$this->analyse([__DIR__ . '/data/null-cast-not-phpdoc.php'], []);
	}

	public function testReportPhpDoc(): void
	{
		$this->treatPhpDocTypesAsCertain = true;
		$this->analyse([__DIR__ . '/data/null-cast-not-phpdoc.php'], [
			[
				'Only non-null values should be cast to int, int|null given.',
				17,
			],
		]);
	}

}
