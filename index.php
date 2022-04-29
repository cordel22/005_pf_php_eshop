<?php

session_start();


$banana = array(
  "id" => 1,
  "img" => "&#127820",
  "name" => "banana",
  "price" => "29",
);
$apple = array(
  "id" => 2,
  "img" => "&#127823",
  "name" => "apple",
  "price" => "39",
);
$pepper = array(
  "id" => 3,
  "img" => "&#127817",
  "name" => "watermelon",
  "price" => "59",
);
$potato = array(
  "id" => 4,
  "img" => "&#129364",
  "name" => "potato",
  "price" => "19",
);
$catalog = array($banana, $apple, $pepper, $potato);
/* 
$_SESSION['cart']['0']['quantity'] = 5;
$_SESSION['cart']['1']['quantity'] = 7;

$_SESSION["cart"]["3"]["quantity"] = 5;
unset($_SESSION["cart"]);
$_SESSION["cart"]["3"]["quantity"] = 5;
$_SESSION['cart']['1']['quantity'] = 7;
 */
function getBy($att, $value, $array)
{
  foreach ($array as $key => $val) {
    if ($val[$att] === $value) {
      return $key;
    }
  }
  return null;
}

if (isset($_GET["action"])) {

  if ($_GET["action"] == "add" && !empty($_GET["id"])) {
    addToCart($_GET["id"]);
    header("Location: /");
  }

  if ($_GET["action"] == "remove" && !empty($_GET["id"])) {
    removeFromCart($_GET["id"]);
    header("Location: /");
  }

  if ($_GET["action"] == "delete" && !empty($_GET["id"])) {
    deleteFromCart($_GET["id"]);
    header("Location: /");
  }
}

function addToCart($productId)
{
  if (!array_key_exists($productId, $_SESSION["cart"])) {
    $_SESSION["cart"][$productId]["quantity"] = 1;
  } else {
    $_SESSION["cart"][$productId]["quantity"]++;
  }
}

function removeFromCart($productId)
{
  if (array_key_exists($productId, $_SESSION["cart"])) {
    if ($_SESSION["cart"][$productId]["quantity"] <= 1) {
      unset($_SESSION["cart"][$productId]);
    } else {
      $_SESSION["cart"][$productId]["quantity"]--;
    }
  }
}

function deleteFromCart($productId)
{
  unset($_SESSION["cart"][$productId]);
}

?>

<html>

<head>
  <style>
    body {
      /* display: flex */
    }


    .catalog-item {
      width: 200px;
      background-color: beige;
      height: 300px;
      margin: 5px;
    }

    .catalog-img {
      font-size: 100px;
    }

    .cart-button,
    .catalog-buy-button {
      margin: 5px;
      padding: 5px;
      border: 1px solid yellow;
      background-color: yellowgreen;
      text-align: center;
    }

    #catalog-items {
      display: flex;
    }

    a.catalog-buy-button {
      display: block;
    }

    #catalog_items {
      display: flex;
    }

    a.catalog_buy_button {
      display: block;
    }

    .cart-item {
      justify-content: space-between;
      display: flex;
      margin: 5px;
      border: 1px solid yellowgreen;
      padding: 5px;
    }

    .cart-quantity {
      margin: 10px;
    }

    .cart-price {
      margin: 10px;

    }

    .cart-control {
      display: flex;
    }

    #cart-total-price {
      font-weight: bold;
    }
  </style>
  <title>
    Apple Store and Some
  </title>
</head>

<body>

  <section>
    <h2>Shopping Cart</h2>
    <?php
    var_dump($_SESSION);
    echo '<br /><br />';
    print_r($_SESSION["cart"]);
    echo '<br /><br />';
    /* print_r($_SESSION["cart"]["2"]); */
    echo 'no ukaz:';
    echo '<br /><br />';
    print_r(getBy("id", 3, $catalog));
    echo '<br /><br />';
    echo 'no ukaz foreach:';
    echo '<br /><br />';
    foreach ($_SESSION["cart"] as $key => $value) {
      print_r(getBy("id", $key, $catalog));
    }
    echo '<br /><br />';
    echo 'no ukaz catalog:';

    $totalPrice = 0;
    foreach ($_SESSION["cart"] as $key => $value) {
      $item = $catalog[getBy("id", $key, $catalog)];
      $totalPrice = $totalPrice + ($item["price"] * $value["quantity"]);
      echo '
<div class="cart-item">
<div class="cart-img">
' . $item["img"] . '
</div>
<h3>
' . $item["name"] . '
</h3>
<div>
<div class="cart-control">
<div class="cart-price">
' . $item["price"] . '
</div>
<div class="cart-quantity">
'  .    ($value["quantity"]) . '
</div>
<div class="cart-quantity">
'  .    ($item["price"] * $value["quantity"]) . '
</div>
<a href="/?action=add&id=' . $item["id"] . '" class="cart-button">
+
</a>
<a href="/?action=remove&id=' . $item["id"] . '" class="cart-button">
-
</a>
<a href="/?action=delete&id=' . $item["id"] . '" class="cart-button">
Remove
</a>
</div>
</div>
</div>';
    }

    echo '<div id="cart-total-price">show me da money : ' . $totalPrice . '</div>';
    /* 
    $totalPrice = 0;
    foreach ($_SESSION["cart"] as $key => $value) {

      $item = $catalog[getBy("id", $key, $catalog)];
      $totalPrice = $totalPrice + ($value["quantity"] * $item["price"]);
      echo '
    <div class="cart-item">
    <div class="cart-img">
    ' . $item["img"] . '
    </div>
    <div>
    ' . $item["name"] . '
    </div>
    <div class="cart-control">
    <div class="cart-price">
    ' . $item["price"] . '
    </div>
    <div class="cart-quantity">
    ' . ($value["quantity"]) . '
    </div>
    <div class="cart-quantity">
    ' . ($value["quantity"] * $item["price"]) . '
    </div>
    <a href="/?action=add&id=' . $item["id"] . '" class="cart-button">
    +
    </a>
    <a href="/?action=remove&id=' . $item["id"] . '" class="cart-button">
    -
    </a>
    <a href="/?action=delete&id=' . $item["id"] . '" class="cart-button">
    x
    </a>
    </div>
    </div>';
    }

    echo "<div id='cart-total-price'>Total price: $totalPrice</div>";
 */    ?>
  </section>

  <section id='catalog-items'>
    <?php


    /* print_r($catalog); */

    foreach ($catalog as $item) {
      echo '
<div class="catalog-item">
<div class="catalog-img">
' . $item["img"] . '
</div>
<h3>
' . $item["name"] . '
</h3>
<div>
' . $item["price"] . '
</div>
<a href="/?action=add&id=' . $item["id"] . '" class="catalog-buy-button">
Buy
</a>
</div>';
      /* 
  echo '<br /><br />';
  print_r($item);
  echo '<br /><br />'; */
    }

    ?>
  </section>
</body>

</html>