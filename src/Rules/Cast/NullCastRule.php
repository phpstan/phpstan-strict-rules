<?php declare(strict_types = 1);

namespace PHPStan\Rules\Cast;

use PhpParser\Node;
use PhpParser\Node\Expr\Cast;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ErrorType;
use PHPStan\Type\GeneralizePrecision;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\VerbosityLevel;
use function sprintf;

/**
 * @implements Rule<Cast>
 */
class NullCastRule implements Rule
{

	/** @var bool */
	private $treatPhpDocTypesAsCertain;

	public function __construct(bool $treatPhpDocTypesAsCertain)
	{
		$this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
	}

	public function getNodeType(): string
	{
		return Cast::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
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

		// This is handled by PhpStan at level 9
		if ($expressionType->isSuperTypeOf(new MixedType())->yes()) {
			return [];
		}

		if (!$expressionType->isNull()->no()) {
			$addTip = function (RuleErrorBuilder $ruleErrorBuilder) use ($scope, $node): RuleErrorBuilder {
				if (!$this->treatPhpDocTypesAsCertain) {
					return $ruleErrorBuilder;
				}

				$expressionTypeWithoutPhpDoc = $scope->getNativeType($node->expr);
				if (!(new NullType())->isSuperTypeOf($expressionTypeWithoutPhpDoc)->no()) {
					return $ruleErrorBuilder;
				}

				return $ruleErrorBuilder->tip('Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.');
			};
			return [
				$addTip(RuleErrorBuilder::message(sprintf(
					'Only non-null values should be cast to %s, %s given.',
					$castType->describe(VerbosityLevel::typeOnly()),
					$expressionType->describe(VerbosityLevel::typeOnly())
				)))->identifier('cast.null')->build(),
			];
		}

		return [];
	}

}
