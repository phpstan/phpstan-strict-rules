<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\PhpDoc\TypeStringResolver;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\TypeParser;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class OperandsInComparisonGreaterOrEqualRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInComparisonGreaterOrEqualRule(
			new OperatorRuleHelper(
				new RuleLevelHelper($this->createBroker(), true, false, true),
                new TypeStringResolver(
                    new Lexer(),
                    new TypeParser(),
                    new TypeNodeResolver([])
                ),
                'int|float|DateTimeInterface'
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/comparison-operators.php'], [
			[
				'Only int|float|DateTimeInterface is allowed in >=, string given on the right side.',
				108,
			],
			[
				'Only int|float|DateTimeInterface is allowed in >=, null given on the right side.',
				111,
			],
			[
				'Only int|float|DateTimeInterface is allowed in >=, null given on the right side.',
				117,
			],
		]);
	}

}
