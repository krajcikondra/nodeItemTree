<?php

namespace Helbrary\NodeItemTree;
use Helbrary\NodeItemTree\Renderer\TreeRenderer;

/**
 * Class Tree
 * @author Ondrej Krajcik
 * @package Helbrary\NodeItemTree
 * @method TreeNode[] findNodes
 * @method TreeNode getNode
 * @method TreeNode[] findRootNodes
 * @method TreeNode[] findPathNode
 */
class Tree extends AbstractTree
{

	/**
	 * @var TreeNode[]
	 */
	protected $roots = [];

	/**
	 * @var TreeRenderer
	 */
	private $renderer;


	public function __construct()
	{
		$this->renderer = new TreeRenderer($this);
	}

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
		if ($parentKey!== NULL && !array_key_exists($parentKey, $this->nodes)) {
			throw new ParentNodeNotFoundException($parentKey);
		}

		$node = new TreeNode($key, $value, $data, $parentKey === NULL ? NULL : $this->nodes[$parentKey]);
		$this->attacheNode($node);
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
	 * Return rendered tree
	 * @return string - html code
	 */
	public function render()
	{
		return $this->renderer->render();
	}

	/**
	 * Return renderer
	 * @return TreeRenderer
	 */
	public function getRenderer()
	{
		return $this->renderer;
	}

}
