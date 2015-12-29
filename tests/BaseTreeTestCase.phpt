<?php

use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';

class BaseTreeTestCase extends \Tester\TestCase
{

	/**
	 * @var \Helbrary\NodeItemTree\Tree
	 */
	private $tree;

	public function setUp()
	{
		$this->tree = $this->buildTree();
	}

	/**
	 * Build tree with categories
	 * @return \Helbrary\NodeItemTree\Tree
	 */
	private function buildTree()
	{
		$tree = new \Helbrary\NodeItemTree\Tree();

		// add root categories
		$tree->addNode(1, 'Car', ['highlight' => TRUE]);
		$tree->addNode(2, 'Clothing', ['highlight' => FALSE]);
		$tree->addNode(3, 'Garden', ['highlight' => TRUE]);
		$tree->addNode(4, 'Electro', ['highlight' => FALSE]);

		// add subcategories

		$tree->addNode(5, 'Sport car', ['highlight' => TRUE], 1);
		$tree->addNode(6, 'Hathback', ['highlight' => FALSE], 1);

		$tree->addNode(7, 'Shirts', ['highlight' => FALSE], 2);
		$tree->addNode(8, 'Pants', ['highlight' => FALSE], 2);

		$tree->addNode(9, 'Reaper', ['highlight' => FALSE], 3);
		$tree->addNode(10, 'Flowers', ['highlight' => TRUE], 3);

		$tree->addNode(11, 'Camera', ['highlight' => FALSE], 4);
		$tree->addNode(12, 'Phone', ['highlight' => FALSE], 4);
		$tree->addNode(13, 'Tablet', ['highlight' => FALSE], 4);
		$tree->addNode(14, 'Computer', [], 4);
		$tree->addNode(15, 'Notebook', ['highlight' => FALSE], 14);
		$tree->addNode(15, 'Ultrabook', ['highlight' => FALSE], 14);
		$tree->addNode(16, 'PC', ['highlight' => FALSE], 14);

		$tree->addNode(17, 'Gaming PC', ['highlight' => FALSE], 16);
		return $tree;
	}

	public function testPathToCategory()
	{
		$path = $this->tree->getPathToNode(17);
		Assert::same([4, 14, 16], $path);
	}

	public function testFindRootNodes()
	{
		$rootNodes = $this->tree->findRootNodes();
		Assert::same(1, $rootNodes[1]->getKey());
		Assert::same(2, $rootNodes[2]->getKey());
		Assert::same(3, $rootNodes[3]->getKey());
		Assert::same(4, $rootNodes[4]->getKey());
	}

	public function testGetData()
	{
		$node = $this->tree->getNode(10);
		$nodeData = $node->getData();
		Assert::same($nodeData['highlight'], TRUE);
	}

	public function testContainsDescendant()
	{
		$contains = $this->tree->getNode(4)->containsDescendant(17);
		Assert::same(TRUE, $contains);
		$contains = $this->tree->getNode(1)->containsDescendant(15);
		Assert::same(FALSE, $contains);
	}

}

$testCase = new BaseTreeTestCase();
$testCase->run();