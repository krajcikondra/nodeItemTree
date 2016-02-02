<?php

namespace Helbrary\NodeItemTree\Traversal;

/**
 * Class TreeNode
 * @package Helbrary\NodeItemTree\Traversal
 */
class TreeNode extends \Helbrary\NodeItemTree\TreeNode
{

	/**
	 * @var int
	 */
	public $left;

	/**
	 * @var int
	 */
	public $right;

	public function __construct($key, $value, $data, $parentNode = NULL)
	{
		parent::__construct($key, $value, $data, $parentNode);
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