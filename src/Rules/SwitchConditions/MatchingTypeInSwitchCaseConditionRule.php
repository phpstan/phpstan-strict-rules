<?php declare(strict_types = 1);

namespace PHPStan\Rules\SwitchConditions;

use PhpParser\Node;
use PhpParser\Node\Stmt\Switch_;
use PhpParser\PrettyPrinter\Standard;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\VerbosityLevel;
use function sprintf;

/**
 * @implements Rule<Switch_>
 */
class MatchingTypeInSwitchCaseConditionRule implements Rule
{

	/** @var Standard */
	private $printer;

	public function __construct(Standard $printer)
	{
		$this->printer = $printer;
	}

	public function getNodeType(): string
	{
		return Switch_::class;
	}

	public function processNode(Node $node, Scope $scope): array
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

			$messages[] = RuleErrorBuilder::message(sprintf(
				'Switch condition type (%s) does not match case condition %s (%s).',
				$conditionType->describe(VerbosityLevel::value()),
				$this->printer->prettyPrintExpr($case->cond),
				$caseType->describe(VerbosityLevel::typeOnly())
			))->line($case->getLine())->build();
		}

		return $messages;
	}

}
