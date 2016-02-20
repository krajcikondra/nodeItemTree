<?php

use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';

/**
 * Class Tree
 * @author Ondrej Krajcik
 * @package Helbrary\NodeItemTree
 */
class BaseTreeTestCase extends \Tester\TestCase
{

	/**
	 * @var \Helbrary\NodeItemTree\Tree
	 */
	private $tree;

	public function setUp()
	{
		\Tester\Environment::setup();
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

		$tree->addNode(9, 'Reaper', ['highlight' => FALSE], 3); // will be ever without items
		$tree->addNode(10, 'Flowers', ['highlight' => TRUE], 3);

		$tree->addNode(11, 'Camera', ['highlight' => FALSE], 4);
		$tree->addNode(12, 'Phone', ['highlight' => FALSE], 4);
		$tree->addNode(13, 'Tablet', ['highlight' => FALSE], 4);
		$tree->addNode(14, 'Computer', [], 4);
		$tree->addNode(15, 'Notebook', ['highlight' => FALSE], 14);
		$tree->addNode(16, 'Ultrabook', ['highlight' => FALSE], 14);
		$tree->addNode(17, 'PC', ['highlight' => FALSE], 14);

		$tree->addNode(18, 'Gaming PC', ['highlight' => FALSE], 17);

		// add items to categories
		$tree->addItem(1, 1, 'Skoda Octavia', array());
		$tree->addItem(5, 2, 'Porsche 911', array());
		$tree->addItem(6, 3, 'Volswagen Golf', array());
		$tree->addItem(6, 4, 'Volswagen Polo', array());
		$tree->addItem(5, 5, 'Honda Prelude', array());

		return $tree;
	}

	public function testPathToCategory()
	{
		$pathToNode = $this->tree->findPathToNode(18, FALSE);
		Assert::same([4, 14, 17], array_keys($pathToNode));
		Assert::count(3, $pathToNode);
		Assert::same('Electro', $pathToNode[4]->getValue());
		Assert::same('Computer', $pathToNode[14]->getValue());
		Assert::same('PC', $pathToNode[17]->getValue());

		$pathToNode = $this->tree->findPathToNode(18);
		Assert::count(4, $pathToNode);

		Assert::same([4, 14, 17, 18], array_keys($pathToNode));
		Assert::same('Electro', $pathToNode[4]->getValue());
		Assert::same('Computer', $pathToNode[14]->getValue());
		Assert::same('PC', $pathToNode[17]->getValue());;
		Assert::same('Gaming PC', $pathToNode[18]->getValue());;
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

	public function testContainsDescendantNodes()
	{
		$contains = $this->tree->getNode(4)->containsDescendant(17);
		Assert::true($contains);
		$contains = $this->tree->getNode(1)->containsDescendant(15);
		Assert::false($contains);
		$items = $this->tree->getNode(9)->findItems();
		Assert::count(0, $items);
	}

	public function testContainsDescendantItems()
	{
		$items = $this->tree->getNode(1)->findItems(TRUE);
		Assert::contains(1, array_keys($items));
		Assert::contains(2, array_keys($items));
		Assert::contains(3, array_keys($items));
		Assert::contains(4, array_keys($items));
		Assert::contains(5, array_keys($items));

		$items = $this->tree->getNode(1)->findItems();
		Assert::contains(1, array_keys($items));
		Assert::count(1, $items);
	}

	public function testAddNode()
	{
		$tree = $this->tree;
		Assert::exception(function() use ($tree) {
			$this->tree->addNode(30, 'My failure node', [], 100005); // parent node with key 100005 does not exist
			}, \Helbrary\NodeItemTree\ParentNodeNotFoundException::class);

		Assert::exception(function() use ($tree) {
			$this->tree->addNode(3, 'Node with duplicite key', [], 1);
		}, \Helbrary\NodeItemTree\NodeWithKeyAlreadyExistException::class);
	}

	public function testHasNodes()
	{
		Assert::true($this->tree->getNode(14)->hasNodes());
		Assert::false($this->tree->getNode(16)->hasNodes());
	}

	public function testRemoveNode()
	{
		Assert::same(18, count($this->tree->findNodes()));
		Assert::noError(function() {
			$this->tree->getNode(15);
		});
		$this->tree->removeNode(14);

		Assert::same(13, count($this->tree->findNodes()));
		Assert::exception(function() {
			$this->tree->getNode(15);
		}, \Helbrary\NodeItemTree\NodeNotFoundException::class);
		$this->tree->removeNode(1);
		$this->tree->removeNode(2);
		$this->tree->removeNode(3);
		$this->tree->removeNode(4);
		Assert::same(0, count($this->tree->findNodes()));
	}

}

$testCase = new BaseTreeTestCase();
$testCase->run();