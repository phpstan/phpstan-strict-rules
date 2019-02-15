<?php declare(strict_types = 1);

namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\MixedType;
use PHPStan\Type\VerbosityLevel;

final class MissingFunctionReturnTypehintRule implements \PHPStan\Rules\Rule
{

	/** @var Broker */
	private $broker;

	public function __construct(Broker $broker)
	{
		$this->broker = $broker;
	}

	public function getNodeType(): string
	{
		return \PhpParser\Node\Stmt\Function_::class;
	}

	/**
	 * @param \PhpParser\Node\Stmt\Function_ $node
	 * @param \PHPStan\Analyser\Scope $scope
	 *
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		$functionReflection = $this->broker->getCustomFunction(new Node\Name($node->name->name), $scope);
		$returnType = ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();

		if ($returnType instanceof MixedType && !$returnType->isExplicitMixed()) {
			return [
				sprintf(
					'Function %s() has no return typehint specified.',
					$functionReflection->getName()
				),
			];
		}

		if ($returnType->isIterable()->yes() && $returnType->getIterableValueType() instanceof MixedType) {
			return [
				sprintf(
					'Function %s() has a return type %s with no value type specified.',
					$functionReflection->getName(),
					$returnType->describe(VerbosityLevel::typeOnly())
				),
			];
		}

		return [];
	}

}
