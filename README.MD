# NodeItemTree

![Alt text](tree.png?raw=true "Tree")

Example: Products in categories
```sh

$tree->addNode(1, 'All categories', array()); // root

// subcategories of category 'All categories'
$tree->addNode(2, 'Computer', array(), 1);
$tree->addNode(3, 'Wifi', array(), 1);
$tree->addNode(4, 'other', array(), 1); 

// add products to categories
$tree->addItem(2, 1448, 'My super computer', array('price' => 15000'));  // 1448 = id of product
$tree->addItem(3, 1453, 'My super wifi', array('price' => 800'));  // 1453 = id of product
$tree->addItem(4, 1350, 'My super printer', array('price' => 800'));  // 1350 = id of product

//instead of array with information we can put object

$product = $db->getProduct(1351);
$tree->addItem(4, $product->id,  $product->name, $product);


```

And then we can render tree
```sh
foreach ($tree->findRootNodes() as $rootCategories) {

  foreach ($node->findNodes() as $subCategory) {

  echo $subCategory->getValue(); // name of category

    foreach ($subcategory->findItems() as $product) {
      echo "- " . $product->getValue();     // name of product
    }
  }
}
```


