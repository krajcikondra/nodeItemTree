<?php

namespace Helbrary\NodeItemTree;

/**
 * Class TreeItem
 * @author Ondrej Krajcik
 * @package Helbrary\NodeItemTree
 */
abstract class BaseItem
{

	/**
	 * @var int|string
	 */
	protected $key;

	/**
	 * @var int|string
	 */
	protected $value;

	/**
	 * @var Object|array
	 */
	protected $data;

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
	 * Return key of item
	 * @return int|string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * Return value of item
	 * @return int|string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * Return data of item
	 * @return array|Object
	 */
	public function getData()
	{
		return $this->data;
	}

}