<?php

use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';

/**
 * @testCase
 * Class Tree
 * @author Ondrej Krajcik
 * @package Helbrary\NodeItemTree
 */
class TraversalTreeTest extends \Tester\TestCase
{

	/**
	 * @var \Helbrary\NodeItemTree\Traversal\TraversalTree
	 */
	private $tree;

	public function setUp()
	{
		\Tester\Environment::setup();
		$this->tree = $this->buildTree();
	}

	/**
	 * Build tree with categories
	 * @return \Helbrary\NodeItemTree\Traversal\TraversalTree
	 */
	private function buildTree()
	{
		$tree = new \Helbrary\NodeItemTree\Traversal\TraversalTree();

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


		return $tree;
	}

	public function testBaseRecalculate()
	{
		$pathToNode = $this->tree->findPathToNode(17, FALSE);
		Assert::same([4, 14], array_keys($pathToNode));
		$this->tree->recalculateTree();
		Assert::same(1, $this->tree->getNode(1)->left);
		Assert::same(2, $this->tree->getNode(5)->left);
		Assert::same(3, $this->tree->getNode(5)->right);
		Assert::same(4, $this->tree->getNode(6)->left);
		Assert::same(5, $this->tree->getNode(6)->right);
		Assert::same(6, $this->tree->getNode(1)->right);

		// Clothing
		Assert::same(7, $this->tree->getNode(2)->left);
		Assert::same(8, $this->tree->getNode(7)->left);
		Assert::same(9, $this->tree->getNode(7)->right);
		Assert::same(10, $this->tree->getNode(8)->left);
		Assert::same(11, $this->tree->getNode(8)->right);
		Assert::same(12, $this->tree->getNode(2)->right);

		// Garden
		Assert::same(13, $this->tree->getNode(3)->left);
		Assert::same(14, $this->tree->getNode(9)->left);
		Assert::same(15, $this->tree->getNode(9)->right);
		Assert::same(16, $this->tree->getNode(10)->left);
		Assert::same(17, $this->tree->getNode(10)->right);
		Assert::same(18, $this->tree->getNode(3)->right);

		// Electro
		Assert::same(19, $this->tree->getNode(4)->left);
		Assert::same(20, $this->tree->getNode(11)->left);
		Assert::same(21, $this->tree->getNode(11)->right);
		Assert::same(22, $this->tree->getNode(12)->left);
		Assert::same(23, $this->tree->getNode(12)->right);
		Assert::same(24, $this->tree->getNode(13)->left);
		Assert::same(25, $this->tree->getNode(13)->right);
		Assert::same(26, $this->tree->getNode(14)->left);
		Assert::same(27, $this->tree->getNode(15)->left);
		Assert::same(28, $this->tree->getNode(15)->right);
		Assert::same(29, $this->tree->getNode(16)->left);
		Assert::same(30, $this->tree->getNode(16)->right);
		Assert::same(31, $this->tree->getNode(17)->left);
		Assert::same(32, $this->tree->getNode(18)->left);
		Assert::same(33, $this->tree->getNode(18)->right);
		Assert::same(34, $this->tree->getNode(17)->right);
		Assert::same(35, $this->tree->getNode(14)->right);
		Assert::same(36, $this->tree->getNode(4)->right);

	}

	public function testRemoveRecalculate()
	{
		$this->tree->removeNode(3);
		Assert::same(1, $this->tree->getNode(1)->left);
		Assert::same(2, $this->tree->getNode(5)->left);
		Assert::same(3, $this->tree->getNode(5)->right);
		Assert::same(4, $this->tree->getNode(6)->left);
		Assert::same(5, $this->tree->getNode(6)->right);
		Assert::same(6, $this->tree->getNode(1)->right);

		// Clothing
		Assert::same(7, $this->tree->getNode(2)->left);
		Assert::same(8, $this->tree->getNode(7)->left);
		Assert::same(9, $this->tree->getNode(7)->right);
		Assert::same(10, $this->tree->getNode(8)->left);
		Assert::same(11, $this->tree->getNode(8)->right);
		Assert::same(12, $this->tree->getNode(2)->right);

		// Electro
		Assert::same(13, $this->tree->getNode(4)->left);
		Assert::same(14, $this->tree->getNode(11)->left);
		Assert::same(15, $this->tree->getNode(11)->right);
		Assert::same(16, $this->tree->getNode(12)->left);
		Assert::same(17, $this->tree->getNode(12)->right);
		Assert::same(18, $this->tree->getNode(13)->left);
		Assert::same(19, $this->tree->getNode(13)->right);
		Assert::same(20, $this->tree->getNode(14)->left);
		Assert::same(21, $this->tree->getNode(15)->left);
		Assert::same(22, $this->tree->getNode(15)->right);
		Assert::same(23, $this->tree->getNode(16)->left);
		Assert::same(24, $this->tree->getNode(16)->right);
		Assert::same(25, $this->tree->getNode(17)->left);
		Assert::same(26, $this->tree->getNode(18)->left);
		Assert::same(27, $this->tree->getNode(18)->right);
		Assert::same(28, $this->tree->getNode(17)->right);
		Assert::same(29, $this->tree->getNode(14)->right);
		Assert::same(30, $this->tree->getNode(4)->right);
	}

	public function testAddRecalculate()
	{
		$this->tree->addNode(37, 'Black', array(), 6); //@todo co kdyz pouziju metodu pro vlozeni v nodu? to pak nemuzu pouzivat v tree metodu findNodes tak ze vratim nodes, instancni promenna nodes v Tree by se tim padem mela uplne zrusit

		Assert::same(1, $this->tree->getNode(1)->left);
		Assert::same(2, $this->tree->getNode(5)->left);
		Assert::same(3, $this->tree->getNode(5)->right);
		Assert::same(4, $this->tree->getNode(6)->left);
		Assert::same(5, $this->tree->getNode(37)->left);
		Assert::same(6, $this->tree->getNode(37)->right);
		Assert::same(7, $this->tree->getNode(6)->right);
		Assert::same(8, $this->tree->getNode(1)->right);

		// Clothing
		Assert::same(9, $this->tree->getNode(2)->left);
		Assert::same(10, $this->tree->getNode(7)->left);
		Assert::same(11, $this->tree->getNode(7)->right);
		Assert::same(12, $this->tree->getNode(8)->left);
		Assert::same(13, $this->tree->getNode(8)->right);
		Assert::same(14, $this->tree->getNode(2)->right);

		// Garden
		Assert::same(15, $this->tree->getNode(3)->left);
		Assert::same(16, $this->tree->getNode(9)->left);
		Assert::same(17, $this->tree->getNode(9)->right);
		Assert::same(18, $this->tree->getNode(10)->left);
		Assert::same(19, $this->tree->getNode(10)->right);
		Assert::same(20, $this->tree->getNode(3)->right);

		// Electro
		Assert::same(21, $this->tree->getNode(4)->left);
		Assert::same(22, $this->tree->getNode(11)->left);
		Assert::same(23, $this->tree->getNode(11)->right);
		Assert::same(24, $this->tree->getNode(12)->left);
		Assert::same(25, $this->tree->getNode(12)->right);
		Assert::same(26, $this->tree->getNode(13)->left);
		Assert::same(27, $this->tree->getNode(13)->right);
		Assert::same(28, $this->tree->getNode(14)->left);
		Assert::same(29, $this->tree->getNode(15)->left);
		Assert::same(30, $this->tree->getNode(15)->right);
		Assert::same(31, $this->tree->getNode(16)->left);
		Assert::same(32, $this->tree->getNode(16)->right);
		Assert::same(33, $this->tree->getNode(17)->left);
		Assert::same(34, $this->tree->getNode(18)->left);
		Assert::same(35, $this->tree->getNode(18)->right);
		Assert::same(36, $this->tree->getNode(17)->right);
		Assert::same(37, $this->tree->getNode(14)->right);
		Assert::same(38, $this->tree->getNode(4)->right);

	}

}

$testCase = new TraversalTreeTest();
$testCase->run();