<?php

namespace Helbrary\NodeItemTree;

interface INode
{

	/**
	 * Return key of node
	 * @return int|string
	 */
	public function getKey();

	/**
	 * Return value of node
	 * @return int|string
	 */
	public function getValue();
	/**
	 * Return data of node
	 * @return array|mixed
	 */
	public function getData();
	/**
	 * Return parent node
	 * @return TreeNode|INode|null
	 */
	public function getParentNode();

	/**
	 * Return all descendants
	 * @return TreeNode[]|INode[]
	 */
	public function findDescendants();
}
