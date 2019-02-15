<?php declare(strict_types = 1);

namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;

final class MissingFunctionParameterTypehintRule implements \PHPStan\Rules\Rule
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

	private function checkFunctionParameter(FunctionReflection $functionReflection, ParameterReflection $parameterReflection): ?string
	{
		$parameterType = $parameterReflection->getType();

		if ($parameterType instanceof MixedType && !$parameterType->isExplicitMixed()) {
			return sprintf(
				'Function %s() has parameter $%s with no typehint specified.',
				$functionReflection->getName(),
				$parameterReflection->getName()
			);
		}

		if ($parameterType->isIterable()->yes()) {
			return $this->checkFunctionIterableParameter(
				$functionReflection,
				$parameterReflection,
				$parameterType
			);
		}

		return null;
	}


	private function checkFunctionIterableParameter(
		FunctionReflection $functionReflection,
		ParameterReflection $parameterReflection,
		Type $parameterType
	): ?string
	{
		$valueType = $parameterType->getIterableValueType();

		if (!$valueType instanceof MixedType) {
			return null;
		}

		return sprintf(
			'Function %s() has parameter $%s with a type %s but no value type specified.',
			$functionReflection->getName(),
			$parameterReflection->getName(),
			$parameterType->describe(VerbosityLevel::typeOnly())
		);
	}

}
