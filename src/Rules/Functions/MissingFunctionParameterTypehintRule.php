<?php declare(strict_types = 1);

namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Type\MixedType;

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
		$functionReflection = $this->broker->getCustomFunction(new Node\Name($node->name), $scope);

		$messages = [];

		foreach ($functionReflection->getParameters() as $parameterReflection) {
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

		return null;
	}

}
