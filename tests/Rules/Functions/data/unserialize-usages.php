<?php declare(strict_types = 1);

namespace UnserializeAllowedClasses;

final class UnserializeUsages
{

	public function noOptions(string $data): mixed
	{
		return unserialize($data);
	}

	public function emptyOptions(string $data): mixed
	{
		return unserialize($data, []);
	}

	public function optionsWithoutAllowedClasses(string $data): mixed
	{
		return unserialize($data, ['some_other_key' => true]);
	}

	/** @return array<string, mixed> */
	public function allowedClassesFalse(string $data): array
	{
		/** @var array<string, mixed> $result */
		$result = unserialize($data, ['allowed_classes' => false]);

		return $result;
	}

	/** @return array<string, mixed> */
	public function allowedClassesExplicitTrue(string $data): array
	{
		/** @var array<string, mixed> $result */
		$result = unserialize($data, ['allowed_classes' => true]);

		return $result;
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
