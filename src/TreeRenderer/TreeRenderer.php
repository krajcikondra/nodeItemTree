<?php

namespace Helbrary\NodeItemTree\Renderer;

use Helbrary\NodeItemTree\Tree;
use Latte\Engine;

class TreeRenderer
{

	/**
	 * @var Tree
	 */
	private $tree;

	/**
	 * @var Engine
	 */
	private $template;

	/**
	 * @var string|bool
	 */
	private $actionTemplatePath;

	/**
	 * Element id of input
	 * @var string
	 */
	private $targetInputForChooser = FALSE;

	/**
	 * @var int - key of node
	 */
	private $activeNode;

	/**
	 * @param Tree $tree
	 */
	public function __construct(Tree $tree)
	{
		$this->tree = $tree;
		$this->template = new Engine();
		$this->actionTemplatePath = __DIR__ . DIRECTORY_SEPARATOR . 'chooser.latte';
	}

	public function render()
	{
		return $this->template->renderToString( __DIR__ . DIRECTORY_SEPARATOR . 'tree.latte', array(
			'tree' => $this->tree,
			'actionTemplatePath' => $this->actionTemplatePath,
			'targetInputForChooser' => $this->targetInputForChooser,
			'activeNode' => $this->activeNode,
		));
	}

	/**
	 * Set path to template for ever item on right side of item
	 * @param string $templatePath
	 */
	public function setActionItemTemplate($templatePath)
	{
		$this->actionTemplatePath = $templatePath;
	}

	/**
	 * Set element id of target input
	 * @param string $inputId
	 */
	public function setTargetInputForChooseNode($inputId)
	{
		$this->targetInputForChooser = $inputId;
	}

	/**
	 * Set active nodes
	 * @param int $key
	 */
	public function setActiveNodes($key)
	{
		$this->activeNode = $key;
	}
}
