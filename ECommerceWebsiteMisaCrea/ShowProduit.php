<?php
require_once("header.php");
require_once("footer.php");
require_once("bdconnexion.php");

if(isset($_POST["add_to_cart"]))
{
  if(isset($_SESSION["shopping_cart"]))
  {
    $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
    if(!in_array($_GET["id"], $item_array_id))
    {
      $count = count($_SESSION["shopping_cart"]);
      $item_array = array(
        'item_id'     =>  $_GET["id"],
        'item_name'     =>  $_POST["hidden_name"],
        'item_price'    =>  $_POST["hidden_price"],
        'item_quantity'   =>  $_POST["quantity"]
      );
      $_SESSION["shopping_cart"][$count] = $item_array;
    }
    else
    {
      echo '<script>alert("Item Already Added")</script>';
    }
  }
  else
  {
    $item_array = array(
      'item_id'     =>  $_GET["id"],
      'item_name'     =>  $_POST["hidden_name"],
      'item_price'    =>  $_POST["hidden_price"],
      'item_quantity'   =>  $_POST["quantity"]
    );
    $_SESSION["shopping_cart"][0] = $item_array;
  }
}




$id=$_GET['id'];
$query1 = "SELECT * FROM products WHERE id=$id ";
$result2 = mysqli_query($database, $query1);
if(mysqli_num_rows($result2) > 0){
    while($row = mysqli_fetch_array($result2)){
?>
</br></br></br>
<link rel="stylesheet" type="text/css" href="css/produit.css">
<div class='container'>
  <div class='background-element' id='background-element'>
  </div>
  <div class='highlight-window'> <img class="ay" src="picture/<?php echo $row["title"]; ?>.jpg"/>
    </div>
  <div class='window'>
    <div class='main-content'>
      <h2>Produit<span style="float:right;cursor:pointer;background-color:darkgrey;color:#36648B;" onclick="location.href='produit.php';">Revenir à l'arrière</span></h2>
      <h1><?php echo $row["title"]; ?></h1>
      <div class='description' id='description'>
      <?php echo $row["description"]; ?></div>
            <div></div>
            <div class='divider'></div>

	<div class='purchase-info'>
      <div class='price'><?php echo $row["price"]; ?>€</div>

      <div class="col-md-4">
        <form method="post" action="?action=add&id=<?php echo $row["id"]; ?>">
          <div style=" border-radius:5px;" align="right">

            Quantité : <input type="number" name="quantity" value="1" style="width:20%;" class="form-control" min="1" />

            <input type="hidden" name="hidden_name" value="<?php echo $row["title"]; ?>" />
            <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />
            <input type="hidden" name="hidden_desclon" value="<?php echo $row["description"]; ?>" />
			
          </div>
		  
			<button type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart">Ajouter au panier</button>
			<a style="margin-left:10px;margin-bottom: 20px;" href="panier.php" >Panier</a>
			
        </form>
      </div>
    </div>
</div>
</div>
  <?php
}}
?>
 
</div>