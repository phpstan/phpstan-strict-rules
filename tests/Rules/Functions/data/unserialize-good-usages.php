<?php declare(strict_types = 1);

namespace UnserializeAllowedClasses;

final class UnserializeUsagesOk
{

	/** @return array<string, mixed> */
	public function allowedClassesFalse(string $data): array
	{
		/** @var array<string, mixed> $result */
		$result = unserialize($data, ['allowed_classes' => false]);

		return $result;
	}

	public function allowedClassesExplicitTrue(string $data): mixed
	{
		return unserialize($data, ['allowed_classes' => true]);
	}

	public function allowedClassesList(string $data): mixed
	{
		return unserialize($data, ['allowed_classes' => [\stdClass::class]]);
	}

	public function dynamicOptions(string $data, mixed $options): mixed
	{
		return unserialize($data, $options);
	}

}
