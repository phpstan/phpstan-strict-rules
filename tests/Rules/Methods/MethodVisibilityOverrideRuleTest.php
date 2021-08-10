<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

class MethodVisibilityOverrideRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		return new MethodVisibilityOverrideRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/visibility-override.php'], [
			[
				'Method MethodVisibilityOverride\\SubClass::foo3() overrides visibility from protected to public',
				63,
			],
			[
				'Method MethodVisibilityOverride\\OtherSubSubClass::foo3() overrides visibility from protected to public',
				93,
			],
		]);
	}

}
