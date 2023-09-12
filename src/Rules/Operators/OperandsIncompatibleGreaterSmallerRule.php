<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Greater as BinaryOpGreater;
use PhpParser\Node\Expr\BinaryOp\GreaterOrEqual as BinaryOpGreaterOrEqual;
use PhpParser\Node\Expr\BinaryOp\Smaller as BinaryOpSmaller;
use PhpParser\Node\Expr\BinaryOp\SmallerOrEqual as BinaryOpSmallerOrEqual;
use PhpParser\Node\Expr\BinaryOp\Spaceship as BinaryOpSpaceship;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
use function sprintf;

/**
 * @implements Rule<Expr>
 */
class OperandsIncompatibleGreaterSmallerRule implements Rule
{

	/** @var bool */
	private $bleedingEdge;

	public function __construct(bool $bleedingEdge)
	{
		$this->bleedingEdge = $bleedingEdge;
	}

	public function getNodeType(): string
	{
		return Expr::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		if (!$this->bleedingEdge) {
			return [];
		}

		if (!$node instanceof BinaryOpSpaceship
			&& !$node instanceof BinaryOpGreater
			&& !$node instanceof BinaryOpGreaterOrEqual
			&& !$node instanceof BinaryOpSmaller
			&& !$node instanceof BinaryOpSmallerOrEqual
		) {
			return [];
		}

		$leftType = $scope->getType($node->left);
		$rightType = $scope->getType($node->right);

		if ($node instanceof BinaryOpSpaceship && $leftType->isBoolean()->yes() && $rightType->isBoolean()->yes()) {
			return [];
		}

		if ($leftType->isInteger()->yes() && $node instanceof BinaryOpSmaller && $this->containsBoolean($rightType)) {
			return [];
		}

		if ($rightType->isInteger()->yes() && $node instanceof BinaryOpGreater && $this->containsBoolean($leftType)) {
			return [];
		}

		if ($this->containsBoolean($leftType) || $this->containsBoolean($rightType)) {
			return [RuleErrorBuilder::message(sprintf(
				'Comparison operator "%s" between %s and %s is not allowed.',
				$node->getOperatorSigil(),
				$leftType->describe(VerbosityLevel::typeOnly()),
				$rightType->describe(VerbosityLevel::typeOnly())
			))->identifier('cmp.hasBool')->build()];
		}

		return [];
	}

	private function containsBoolean(Type $type): bool
	{
		if ($type->isBoolean()->yes()) {
			return true;
		}

		if ($type instanceof UnionType) {
			foreach ($type->getTypes() as $inUnionType) {
				if ($inUnionType->isBoolean()->yes()) {
					return true;
				}
			}
		}

		return false;
	}

}
