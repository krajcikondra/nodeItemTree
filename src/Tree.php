<?php

namespace Helbrary\NodeItemTree;

/**
 * Class Tree
 * @author Ondrej Krajcik
 * @package Helbrary\NodeItemTree
 */
class Tree
{

	/**
	 * @var TreeNode[]
	 */
	private $nodes = [];

	/**
	 * @var TreeNode[]
	 */
	private $roots = [];


	/**
	 * Add node to tree
	 * @param string|int $key
	 * @param string|int $value
	 * @param array $data
	 * @param string|int $parentKey - if parent key is NULL, node is root
	 * @throws ParentNodeNotFoundException
	 */
	public function addNode($key, $value, $data = [], $parentKey = NULL)
	{

		if ($parentKey === NULL) {
			$node = new TreeNode($key, $value, $data);
			$this->roots[$key] = $node;
		} else {
			if (!array_key_exists($parentKey, $this->nodes)) {
				throw new ParentNodeNotFoundException($parentKey);
			}
			$node = new TreeNode($key, $value, $data, $this->nodes[$parentKey]);
			$this->nodes[$parentKey]->addNode($node);
		}
		$this->nodes[$key] = $node;
	}

	/**
	 * Add item
	 * @param int $nodeKey
	 * @param string|int $itemKey
	 * @param string|int $itemValue
	 * @param array|Object $itemData
	 * @throws NodeNotFoundException
	 */
	public function addItem($nodeKey, $itemKey, $itemValue, $itemData = [])
	{
		if (!array_key_exists($nodeKey, $this->nodes)) {
			throw new NodeNotFoundException($nodeKey);
		}
		$this->nodes[$nodeKey]->addItem(new TreeItem($itemKey, $itemValue, $itemData));
	}

	/**
	 * Exist node in child?
	 * @param int $key
	 * @return bool
	 */
	public function existNode($key)
	{
		if (isset($this->nodes[$key])) return TRUE;
		return FALSE;
	}

	/**
	 * Return roots nodes
	 * @return TreeNode[]
	 */
	public function findRootNodes()
	{
		return $this->roots;
	}

	/**
	 * @deprecated - use instead findPathToNode
	 * Return path from root to node
	 * @param string|int $key
	 * @return int[] - contains node keys in order from root to search node
	 */
	public function getPathToNode($key)
	{
		$node = $this->nodes[$key];
		$nodePathIds = [];
		while (($node = $node->getParentNode())) {
			$nodePathIds[] = $node->getKey();
		}
		return array_reverse($nodePathIds, FALSE);
	}

	/**
	 * Return path from root to node
	 * @param string|int $key
	 * @param bool $includeTargetNode - include target node in path?
	 * @return TreeNode[] - contains node keys in order from root to search node, in format array( $nodeKey => $node )
	 */
	public function findPathToNode($key, $includeTargetNode = TRUE)
	{
		$node = $this->nodes[$key];
		$nodePath = [];

		if ($includeTargetNode) {
			$nodePath[$node->getKey()] = $node;
		}

		while (($node = $node->getParentNode())) {
			$nodePath[$node->getKey()] = $node;
		}
		return array_reverse($nodePath, TRUE);
	}

	/**
	 * Return node
	 * @param int|string $key
	 * @return TreeNode|null
	 */
	public function getNode($key)
	{
		return $this->nodes[$key];
	}

}
