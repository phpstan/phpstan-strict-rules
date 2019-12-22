<?php declare(strict_types = 1);

namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\CallableType;
use PHPStan\Type\ClosureType;
use PHPStan\Type\MixedType;

/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Function_>
 */
final class MissingFunctionParameterCallableReturnTypehintRule implements \PHPStan\Rules\Rule
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

		$messages = [];

		foreach (ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getParameters() as $parameterReflection) {
			$message = $this->checkFunctionParameter($functionReflection, $parameterReflection);
			if ($message === null) {
				continue;
			}

			$messages[] = $message;
		}

		return $messages;
	}

	private function checkFunctionParameter(FunctionReflection $functionReflection, ParameterReflection $parameterReflection): ?RuleError
	{
		$parameterType = $parameterReflection->getType();

		if (!($parameterType instanceof CallableType || $parameterType instanceof ClosureType)) {
			return null;
		}

		$callableReturnType = $parameterType->getReturnType();

		if ($callableReturnType instanceof MixedType && !$callableReturnType->isExplicitMixed()) {
			return RuleErrorBuilder::message(sprintf(
				'Function %s() has callable parameter $%s with no return typehint specified.',
				$functionReflection->getName(),
				$parameterReflection->getName()
			))->build();
		}

		return null;
	}

}
