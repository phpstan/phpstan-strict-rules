<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\PhpDoc\TypeStringResolver;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\TypeParser;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class OperandsInComparisonSpaceshipRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInComparisonSpaceshipRule(
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
				'Only int|float|DateTimeInterface is allowed in <=>, string given on the right side.',
				124,
			],
			[
				'Only int|float|DateTimeInterface is allowed in <=>, null given on the right side.',
				127,
			],
			[
				'Only int|float|DateTimeInterface is allowed in <=>, null given on the right side.',
				133,
			],
		]);
	}

}
