# NodeItemTree - Render

![Alt text](images/renderOfTree.png?raw=true "Tree")

Do you want render tree for user, etc. for choose some node?
```sh
$tree->render();
```

# Customize of rendering

Set active node
```sh
$renderer = $tree->getRenderer();
$renderer->setActiveNode(5);)
```