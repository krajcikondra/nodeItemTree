<?php

namespace Helbrary\NodeItemTree;

abstract class BaseNode
{

	/**
	 * @var string|int
	 */
	protected $key;

	/**
	 * @var string|int
	 */
	protected $value;

	/**
	 * @var array|mixed
	 */
	protected $data;

	/**
	 * @var BaseNode
	 */
	protected $parentNode;

	/**
	 * @var BaseItem[]
	 */
	protected $items = [];

	/**
	 * @var BaseNode[]
	 */
	protected $nodes = [];

	/**
	 * @var BaseTree
	 */
	protected $tree;


	/**
	 * Return key of node
	 * @return int|string
	 */
	public abstract function getKey();

	/**
	 * Return value of node
	 * @return int|string
	 */
	public abstract function getValue();

	/**
	 * Return data of node
	 * @return array|mixed
	 */
	public abstract function getData();

	/**
	 * Return parent node
	 * @return BaseNode|null
	 */
	public abstract function getParentNode();

	/**
	 * Return all descendants
	 * @return BaseNode[]
	 */
	public abstract function findDescendants();

	/**
	 * Has some nodes?
	 * @return bool
	 */
	public function hasNodes()
	{
		return count($this->nodes) > 0;
	}
}
