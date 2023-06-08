<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<DisallowedImplicitArrayCreationRule>
 */
class DisallowedImplicitArrayCreationRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new DisallowedImplicitArrayCreationRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/array-creation.php'], [
			[
				'Implicit array creation is not allowed - variable $b does not exist.',
				11,
			],
			[
				'Implicit array creation is not allowed - variable $c might not exist.',
				17,
			],
			[
				'Implicit array creation is not allowed - variable $d does not exist.',
				18,
			],
		]);
	}

}
