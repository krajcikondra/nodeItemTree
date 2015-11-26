<?php

namespace Helbrary\NodeItemTree;

/**
 * Class TreeItem
 * @author Ondrej Krajcik
 * @package Helbrary\NodeItemTree
 */
class TreeItem
{
	/**
	 * @var int|string
	 */
	private $key;

	/**
	 * @var int|string
	 */
	private $value;

	/**
	 * @var Object|array
	 */
	private $data;

	/**
	 * TreeItem constructor.
	 * @param int|string $key
	 * @param int|string $value
	 * @param array|Object $data
	 */
	public function __construct($key, $value, $data)
	{
		$this->key = $key;
		$this->value = $value;
		$this->data = $data;
	}

	/**
	 * @return int|string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @return int|string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @return array|Object
	 */
	public function getData()
	{
		return $this->data;
	}

}
