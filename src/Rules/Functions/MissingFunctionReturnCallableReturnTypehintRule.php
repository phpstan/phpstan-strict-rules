<?php declare(strict_types = 1);

namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\CallableType;
use PHPStan\Type\ClosureType;
use PHPStan\Type\MixedType;

/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Function_>
 */
final class MissingFunctionReturnCallableReturnTypehintRule implements \PHPStan\Rules\Rule
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

	public function processNode(Node $node, Scope $scope): array
	{
		$functionReflection = $this->broker->getCustomFunction(new Node\Name($node->name->name), $scope);

		$returnType = ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();

		if (!($returnType instanceof CallableType || $returnType instanceof ClosureType)) {
			return [];
		}

		$callableReturnType = $returnType->getReturnType();

		if ($callableReturnType instanceof MixedType && !$callableReturnType->isExplicitMixed()) {
			return [
				RuleErrorBuilder::message(sprintf(
					'Function %s() has callable return type with no return typehint specified.',
					$functionReflection->getName()
				))->build(),
			];
		}

		return [];
	}

}
