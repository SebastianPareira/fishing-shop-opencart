<?php

class OpenGraph
{
	private $title = '';
	private $type = '';
	private $url = '';
	private $image = '';
	private $siteName = '';

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * @param string $image
	 */
	public function setImage($image)
	{
		$this->image = $image;
	}

	/**
	 * @return string
	 */
	public function getSiteName()
	{
		return $this->siteName;
	}

	/**
	 * @param string $siteName
	 */
	public function setSiteName($siteName)
	{
		$this->siteName = $siteName;
	}
}
