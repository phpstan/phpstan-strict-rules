<?php declare(strict_types = 1);

namespace PHPStan\Rules\SwitchConditions;

use PHPStan\Type\VerbosityLevel;

class MatchingTypeInSwitchCaseConditionRule implements \PHPStan\Rules\Rule
{

	/** @var \PhpParser\PrettyPrinter\Standard */
	private $printer;

	public function __construct(\PhpParser\PrettyPrinter\Standard $printer)
	{
		$this->printer = $printer;
	}

	public function getNodeType(): string
	{
		return \PhpParser\Node\Stmt\Switch_::class;
	}

	/**
	 * @param \PhpParser\Node\Stmt\Switch_ $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope): array
	{
		$messages = [];
		$conditionType = $scope->getType($node->cond);
		foreach ($node->cases as $case) {
			if ($case->cond === null) {
				continue;
			}

			$caseType = $scope->getType($case->cond);
			if (!$conditionType->isSuperTypeOf($caseType)->no()) {
				continue;
			}

			$messages[] = sprintf(
				'Switch condition type (%s) does not match case condition %s (%s).',
				$conditionType->describe(VerbosityLevel::value()),
				$this->printer->prettyPrintExpr($case->cond),
				$caseType->describe(VerbosityLevel::typeOnly())
			);
		}

		return $messages;
	}

}
