<?php

namespace Helbrary\NodeItemTree\Traversal;

use Helbrary\NodeItemTree\NodeWithKeyAlreadyExistException;
use Helbrary\NodeItemTree\ParentNodeNotFoundException;
use Helbrary\NodeItemTree\Traversal;
use Helbrary\NodeItemTree\Tree;

/**
 * Class TraversalTree
 * @package Helbrary\NodeItemTree\Traversal
 * @method TreeNode getNode
 */
class TraversalTree extends Tree
{

	/**
	 * Recalculate traversal tree
	 */
	public function recalculateTree()
	{
		$rootNodes = $this->findRootNodes();
		$index = 1;
		foreach ($rootNodes as $node) {
			$index = $this->recalculateNode($node, $index);
		}
	}

	/**
	 * Recalculate traversal node and sub nodes
	 * @param TreeNode $node
	 * @param int $index
	 * @return int
	 */
	private function recalculateNode(TreeNode $node, $index = 0)
	{
		$node->left = $index;
		$index++;
		foreach ($node->findNodes() as $subNode) {
			$index = $this->recalculateNode($subNode, $index);
		}
		$node->right = $index;
		return $index + 1;
	}

	/**
	 * Add node to tree
	 * @param string|int $key
	 * @param string|int $value
	 * @param array $data
	 * @param string|int $parentKey - if parent key is NULL, node is root
	 * @throws ParentNodeNotFoundException
	 * @throws NodeWithKeyAlreadyExistException
	 */
	public function addNode($key, $value, $data = [], $parentKey = NULL)
	{
		if ($parentKey !== NULL && !array_key_exists($parentKey, $this->nodes)) {
			throw new ParentNodeNotFoundException($parentKey);
		}
		$node = new TreeNode($key, $value, $data, $parentKey === NULL ? NULL : $this->nodes[$parentKey]);
		$this->attacheNode($node);
		$this->recalculateTree();
	}

	/**
	 * Remove node by node key
	 * @param int|string $nodeKey
	 */
	public function removeNode($nodeKey)
	{
		parent::removeNode($nodeKey);
		$this->recalculateTree();
	}

}
