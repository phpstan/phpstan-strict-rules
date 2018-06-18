<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PhpParser\Node;
use PHPStan\Analyser\Scope;

class DisallowedEmptyRule implements \PHPStan\Rules\Rule
{

	/** @var bool */
	private $checkEmptyCall;

	public function __construct(bool $checkEmptyCall)
	{
		$this->checkEmptyCall = $checkEmptyCall;
	}

	public function getNodeType(): string
	{
		return \PhpParser\Node\Expr\Empty_::class;
	}

	/**
	 * @param \PhpParser\Node\Expr\Empty_ $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[]
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (!$this->checkEmptyCall) {
			return [];
		}

		return [
			'Construct empty() is not allowed. Use more strict comparison.',
		];
	}

}
