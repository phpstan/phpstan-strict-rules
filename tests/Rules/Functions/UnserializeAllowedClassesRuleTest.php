<?php declare(strict_types = 1);

namespace PHPStan\Rules\Functions;

use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<UnserializeAllowedClassesRule> */
class UnserializeAllowedClassesRuleTest extends RuleTestCase
{

	protected function getRule(): UnserializeAllowedClassesRule
	{
		return new UnserializeAllowedClassesRule();
	}

	public function testViolations(): void
	{
		$this->analyse([__DIR__ . '/data/unserialize-usages.php'], [
			[
				"unserialize() called without the \$options argument. Always pass ['allowed_classes' => false] or an explicit list of safe classes. If you truly need to allow all classes, pass ['allowed_classes' => true] to make that decision explicit.",
				10,
			],
			[
				"unserialize() called without the 'allowed_classes' key in \$options. Always pass ['allowed_classes' => false] or an explicit list of safe classes. If you truly need to allow all classes, pass ['allowed_classes' => true] to make that decision explicit.",
				15,
			],
			[
				"unserialize() called without the 'allowed_classes' key in \$options. Always pass ['allowed_classes' => false] or an explicit list of safe classes. If you truly need to allow all classes, pass ['allowed_classes' => true] to make that decision explicit.",
				20,
			],
		]);
	}

	public function testNoErrors(): void
	{
		$this->analyse([__DIR__ . '/data/unserialize-good-usages.php'], []);
	}

}
