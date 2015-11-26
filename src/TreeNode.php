<?php

namespace Helbrary\NodeItemTree;

/**
 * Class TreeNode
 * @author Ondrej Krajcik
 * @package Helbrary\NodeItemTree
 */
class TreeNode
{

	/**
	 * @var string|int
	 */
	private $key;

	/**
	 * @var string|int
	 */
	private $value;

	/**
	 * @var array|mixed
	 */
	private $data;

	/**
	 * @var array
	 */
	private $items = [];

	/**
	 * @var array
	 */
	private $nodes = [];

	/**
	 * TreeNode constructor.
	 * @param string|int $key
	 * @param string|int|null $value
	 * @param array|mixed $data
	 */
	public function __construct($key, $value = NULL, $data = NULL)
	{
		$this->key = $key;
		$this->value = $value;
		$this->data = $data;
	}

	/**
	 * Return key of node
	 * @return int|string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * Return value of node
	 * @return int|string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * Return data of node
	 * @return array|mixed
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Add node to node
	 * @param TreeNode $node
	 */
	public function addNode(TreeNode $node)
	{
		$this->nodes[$node->getKey()] = $node;
	}

	/**
	 * Add item to node
	 * @param TreeItem $item
	 */
	public function addItem(TreeItem $item)
	{
		$this->items[$item->getKey()] = $item;
	}

	/**
	 * Return all nodes in this nodes
	 * @return TreeNode[]
	 */
	public function findNodes()
	{
		return $this->nodes;
	}

	/**
	 * Return all items in this node
	 * @return TreeItem[]
	 */
	public function findItems()
	{
		return $this->items;
	}

}
