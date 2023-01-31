<?php

namespace Slug;

class DatabaseEntrySlug
{
	private $db;

	/**
	 * @var string
	 */
	private $entryType;

	/**
	 * @var Slug
	 */
	private $slug;

	public function __construct($db, $entryType)
	{
		$this->db = $db;
		$this->entryType = $entryType;
		$this->slug = new Slug();
	}

	public function createSeoUrl($source, $id = null)
	{
		$keyword = $this->slug->make($source);
		$excluded = $id ? "{$this->entryType}_id={$id}" : '';

		while ($this->keywordIsNotUnique($keyword, $excluded)) {
			$keyword .= "-" . time();
		}

		return $keyword;
	}

	protected function keywordIsNotUnique($keyword, $excluded)
	{
		$results = 0;
		$sql = '';

		if (!empty($excluded)) {
			$sql .= " AND query NOT LIKE '" . $excluded . "'";
		}
		try {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE keyword = '" . $keyword . "'" . $sql);
			$results = count($query->rows);
		} catch (Exception $e) {
		}

		return $results;
	}
}