<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;

class InstantiationOfDeprecatedClassRule implements \PHPStan\Rules\Rule
{

	/**
	 * @var Broker
	 */
	private $broker;

	public function __construct(Broker $broker)
	{
		$this->broker = $broker;
	}

	public function getNodeType(): string
	{
		return New_::class;
	}

	/**
	 * @param New_ $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (!$node->class instanceof Name) {
			return [];
		}

		$className = (string) $node->class;

		try {
			$class = $this->broker->getClass($className);
		} catch (\PHPStan\Broker\ClassNotFoundException $e) {
			return [];
		}

		if (!$class->isDeprecated()) {
			return [];
		}

		return [sprintf(
			'Instantiation of deprecated class %s.',
			$className
		)];
	}

}
