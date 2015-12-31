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
	 * @var TreeNode
	 */
	private $parentNode;

	/**
	 * @var array
	 */
	private $items = [];

	/**
	 * @var TreeNode[]
	 */
	private $nodes = [];

	/**
	 * TreeNode constructor.
	 * @param string|int $key
	 * @param string|int|null $value
	 * @param array|mixed|null $data
	 * @param TreeNode|null $parentNode
	 */
	public function __construct($key, $value = NULL, $data = NULL, $parentNode = NULL)
	{
		$this->key = $key;
		$this->value = $value;
		$this->data = $data;
		$this->parentNode = $parentNode;
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
	 * Return parent node
	 * @return TreeNode|null
	 */
	public function getParentNode()
	{
		return $this->parentNode;
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
	 * @param bool $withDescendants - find too items in all descendants?
	 * @return TreeItem[]
	 */
	public function findItems($withDescendants = FALSE)
	{
		if ($withDescendants) {
			$items = $this->findItemsInNodeAndDescendants($this);
			return $items + $this->items;
		}
		return $this->items;
	}

	/**
	 * Find items in node and recursive find items in descendant nodes
	 * @param TreeNode $node
	 * @return array
	 */
	private function findItemsInNodeAndDescendants(TreeNode $node)
	{
		$items = [];
		foreach ($node->findNodes() as $subNode) {
			$items += $subNode->findItems($subNode);
		}
		return $items;
	}

	/**
	 * Contains descendant node?
	 * @param int|string $descendantKey
	 * @return bool
	 */
	public function containsDescendant($descendantKey)
	{
		foreach ($this->nodes as $subNode)
		{
			if ($subNode->getKey() == $descendantKey) return TRUE;
			if ($this->contains($subNode, $descendantKey)) return TRUE;
		}
		return FALSE;
	}

	/**
	 * Contains node some node with search key
	 * @param TreeNode $node
	 * @param int|string $searchKey
	 * @return bool
	 */
	private function contains(TreeNode $node, $searchKey)
	{
		if ($node->getKey() == $searchKey) return TRUE;
		foreach ($node->findNodes() as $subNode) {
			if ($subNode->getKey() == $searchKey) {
				return TRUE;
			}
			if ($this->contains($subNode, $searchKey)) return TRUE;
		}
		return FALSE;
	}

}
