# NodeItemTree - Render

Do you want render tree for user, etc. for choose some node?
```sh
$tree->render();
```

# Tree can looks like in above pictures

![Alt text](images/treeRenderer0.png?raw=true "Tree")
![Alt text](images/treeRenderer1.png?raw=true "Tree")
![Alt text](images/treeRenderer2.png?raw=true "Tree")

# After choose node tree looks like

![Alt text](images/treeRenderChoose.png?raw=true "Tree")

Don´t forget link css styles
```sh
<link rel="stylesheet" href="css/helbrary-tree.css">
```


# Customize of rendering

Set active node
```sh
$renderer = $tree->getRenderer();
$renderer->setActiveNode(5);
```
Customize choose button
```sh
$renderer = $tree->getRenderer();
$renderer->setActionItemTemplate('pathToMyTemplate.latte');

// default action item template - chooser.latte

<a class="helbrary-tree-chooser" data-key="{$node->getKey()}">
Choose
</a>

```

Do you want set key of choose node to some input?
```sh
<input type="text" id="my-input">

$renderer = $tree->getRenderer();
$renderer->setTargetInputForChooseNode('my-input');

// now when I choose some node will be set value of input my-input to key of choose node
```
