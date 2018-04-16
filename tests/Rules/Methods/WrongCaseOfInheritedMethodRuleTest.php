<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

class WrongCaseOfInheritedMethodRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		return new WrongCaseOfInheritedMethodRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/wrong-case.php'], [
			[
				'Method WrongCase\Foo::GETfoo() does not match interface method name: WrongCase\FooInterface::getFoo()',
				25,
			],
			[
				'Method WrongCase\Foo::GETbar() does not match parent method name: WrongCase\FooParent::getBar()',
				30,
			],
		]);
	}

}
