<?php

namespace Helbrary\NodeItemTree;

abstract class BaseTree
{

	/**
	 * @var BaseNode[]
	 */
	protected $nodes = [];

	/**
	 * @var BaseNode[]
	 */
	protected $roots = [];

	/**
	 * Attache node to tree
	 * @param BaseNode $node
	 * @throws NodeWithKeyAlreadyExistException
	 */
	protected function attacheNode(BaseNode $node)
	{
		if (array_key_exists($node->getKey(), $this->nodes)) {
			throw new NodeWithKeyAlreadyExistException($node->getKey());
		}

		if ($node->getParentNode() === NULL) {
			$this->roots[$node->getKey()] = $node;
		} else {
			$this->nodes[$node->getParentNode()->getKey()]->addNode($node);
		}
		$this->nodes[$node->getKey()] = $node;
	}

	/**
	 * Return all nodes
	 * @return BaseNode[]
	 */
	public function findNodes()
	{
		return $this->nodes;
	}

	/**
	 * Return node
	 * @param int|string $key
	 * @return BaseNode|null
	 * @throws NodeNotFoundException
	 */
	public function getNode($key)
	{
		if (!isset($this->nodes[$key])) {
			throw new NodeNotFoundException($key);
		}
		return $this->nodes[$key];
	}

	/**
	 * Return roots nodes
	 * @return BaseNode[]
	 */
	public function findRootNodes()
	{
		return $this->roots;
	}

	/**
	 * Return path from root to node
	 * @param string|int $key
	 * @param bool $includeTargetNode - include target node in path?
	 * @return BaseNode[] - contains node keys in order from root to search node, in format array( $nodeKey => $node )
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
	 * Exist node in child?
	 * @param int $key
	 * @return bool
	 */
	public function existNode($key)
	{
		return isset($this->nodes[$key]);
	}

	/**
	 * Remove node by node key
	 * @param int|string $nodeKey
	 */
	public function removeNode($nodeKey)
	{
		$node = $this->getNode($nodeKey);
		$descendantNodes = $node->findDescendants();
		foreach ($descendantNodes as $node) {
			unset($this->nodes[$node->getKey()]);
			unset($this->roots[$node->getKey()]);
		}
		unset($this->nodes[$nodeKey]);
		unset($this->roots[$nodeKey]);
	}

}
