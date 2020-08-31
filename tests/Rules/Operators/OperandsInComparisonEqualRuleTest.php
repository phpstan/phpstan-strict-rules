<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\PhpDoc\TypeStringResolver;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\TypeParser;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class OperandsInComparisonEqualRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInComparisonEqualRule(
			new OperatorRuleHelper(
				new RuleLevelHelper($this->createBroker(), true, false, true),
				new TypeStringResolver(
					new Lexer(),
					new TypeParser(),
					new TypeNodeResolver([], self::getContainer())
				),
				'int|float|DateTimeInterface'
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/comparison-operators.php'], [
			[
				'Only int|float|DateTimeInterface is allowed in ==, string given on the right side.',
				25,
			],
			[
				'Only int|float|DateTimeInterface is allowed in ==, null given on the right side.',
				28,
			],
			[
				'Only int|float|DateTimeInterface is allowed in ==, null given on the right side.',
				34,
			],
			[
				'Only int|float|DateTimeInterface is allowed in ==, (array<int, string>|false) given on the left side.',
				148,
			],
		]);
	}

}
