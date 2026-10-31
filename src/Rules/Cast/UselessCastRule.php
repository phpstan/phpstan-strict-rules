<?php declare(strict_types = 1);

namespace PHPStan\Rules\Cast;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Cast;
use PhpParser\Node\Expr\Cast\Void_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ErrorType;
use PHPStan\Type\GeneralizePrecision;
use PHPStan\Type\VerbosityLevel;
use function sprintf;

/**
 * @implements Rule<Cast>
 */
class UselessCastRule implements Rule
{

	private bool $treatPhpDocTypesAsCertain;

	private bool $treatPhpDocTypesAsCertainTip;

	public function __construct(
		bool $treatPhpDocTypesAsCertain,
		bool $treatPhpDocTypesAsCertainTip
	)
	{
		$this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
		$this->treatPhpDocTypesAsCertainTip = $treatPhpDocTypesAsCertainTip;
	}

	public function getNodeType(): string
	{
		return Cast::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		if ($node instanceof Void_) {
			return [];
		}

		$castType = $scope->getType($node);
		if ($castType instanceof ErrorType) {
			return [];
		}
		$castType = $castType->generalize(GeneralizePrecision::lessSpecific());

		if ($this->treatPhpDocTypesAsCertain) {
			$expressionType = $scope->getType($node->expr);
		} else {
			$expressionType = $scope->getNativeType($node->expr);
		}
		if ($castType->isSuperTypeOf($expressionType)->yes()) {
			$ruleErrorBuilder = RuleErrorBuilder::message(sprintf(
				'Casting to %s something that\'s already %s.',
				$castType->describe(VerbosityLevel::typeOnly()),
				$expressionType->describe(VerbosityLevel::typeOnly()),
			))->identifier('cast.useless');

			if ($castType->isSuperTypeOf($scope->getNativeType($node->expr))->yes()) {
				$ruleErrorBuilder->fixNode($node, static function (Cast $node): Node {
					// Reprint the operand tree so parentheses reflect operator precedence.
					$traverser = new NodeTraverser();
					$traverser->addVisitor(new class extends NodeVisitorAbstract {

						public function enterNode(Node $node): ?Node
						{
							if ($node instanceof Expr) {
								$node->setAttribute('origNode', null);
							}

							return null;
						}

					});

					return $traverser->traverse([$node->expr])[0];
				});
			} elseif ($this->treatPhpDocTypesAsCertain && $this->treatPhpDocTypesAsCertainTip) {
				$ruleErrorBuilder->treatPhpDocTypesAsCertainTip();
			}

			return [
				$ruleErrorBuilder->build(),
			];
		}

		return [];
	}

}
