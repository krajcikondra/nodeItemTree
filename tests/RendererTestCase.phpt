<?php

use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';

/**
 * Class Tree
 * @author Ondrej Krajcik
 * @package Helbrary\NodeItemTree
 */
class RendererTestCase extends \Tester\TestCase
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
		$tree->addNode(15, 'Ultrabook', ['highlight' => FALSE], 14);
		$tree->addNode(16, 'PC', ['highlight' => FALSE], 14);

		$tree->addNode(17, 'Gaming PC', ['highlight' => FALSE], 16);

		// add items to categories
		$tree->addItem(1, 1, 'Skoda Octavia', array());
		$tree->addItem(5, 2, 'Porsche 911', array());
		$tree->addItem(6, 3, 'Volswagen Golf', array());
		$tree->addItem(6, 4, 'Volswagen Polo', array());
		$tree->addItem(5, 5, 'Honda Prelude', array());

		return $tree;
	}

	public function testBaseRender()
	{
		$html = $this->tree->render();
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		Assert::equal(17, $dom->getElementsByTagName('li')->length);
	}

	public function testActionTemplate()
	{
		$this->tree->getRenderer()->setActionItemTemplate(__DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'testingChooserTemplate.latte');
		$html = $this->tree->render();
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		$xpath = new DOMXPath($dom);

		$query = "//a[@class='testing-link']";
		$entries = $xpath->query($query, $dom);
		Assert::equal(17, $entries->length);
		$tree = $this->tree;
		Assert::exception(function() use ($tree) {
			$this->tree->getRenderer()->setActionItemTemplate('nonexistingfile.txt');
		}, 'Helbrary\NodeItemTree\Renderer\TemplateDoesNotExistException');
	}

	public function testSetActiveNode()
	{
		$this->tree->getRenderer()->setActiveNode(11);
		$html = $this->tree->render();
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		$xpath = new DOMXPath($dom);

		$query = "//ul[@class='helbrary-tree-list']//li[@class='active']/a";
		$entries = $xpath->query($query, $dom);
		Assert::equal(1, $entries->length);

		/** @var DomNode $entry */
		$entry = $entries[0];
		$attribute = $entry->attributes->getNamedItem('data-key');
		Assert::equal((string) 11, $attribute->textContent); // node key can be string or int
	}

}

$testCase = new RendererTestCase();
$testCase->run();