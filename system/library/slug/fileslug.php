<?php

namespace Slug;

class FileSlug
{
	/**
	 * @var Slug
	 */
	private $slug;

	public function __construct()
	{
		$this->slug = new Slug();
	}

	/**
	 * @param string $filename
	 * @return string
	 */
	public function createFileNameSlug($filename)
	{
		$parts = explode('.', $filename);
		$extension = array_pop($parts);

		return $this->slug->make(implode('.', $parts)) . '.' . $extension;
	}
}
