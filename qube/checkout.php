<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn,$_POST['flat']);
   $materials = mysqli_real_escape_string($conn,$_POST['materials']);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ',$cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }else{
      if(mysqli_num_rows($order_query) > 0){
         $message[] = 'order already placed!'; 
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, materials, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$materials', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $message[] = 'order placed successfully!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      }
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>checkout</h3>
   <p> <a href="home.php">home</a> / checkout </p>
</div>

<section class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span><b>(<?php echo '₱'.$fetch_cart['price'].''.' x '. $fetch_cart['quantity']; ?>)</b></span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   <div class="grand-total"> Grand total : <span><b>₱<?php echo $grand_total; ?></b></span> </div>

</section>

<section class="checkout">
   <?php
         $select_name = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select_name) > 0){
            while($fetch_check = mysqli_fetch_assoc($select_name)){
   ?>

   <form action="" method="post">
      <h3>Place your order</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Name :</span>
            <input type="text" name="name" value="<?php echo $fetch_check['name']; ?>" required placeholder="enter your name">
         </div>
         <div class="inputBox">
            <span>Number :</span>
            <input type="text" name="number" value="<?php echo $fetch_check['number']; ?>" required placeholder="enter your number">
         </div>
         <div class="inputBox">
            <span>Email :</span>
            <input type="email" name="email" value="<?php echo $fetch_check['email']; ?>" required placeholder="enter your email">
         </div>
         <div class="inputBox">
            <span>Payment method :</span>
            <select name="method">
               <option value="Cash on delivery">Cash on delivery</option>
               <option value="Credit card">Debit Card</option>
               <option value="Gcash">Gcash</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Material Used :</span>
            <select name="materials">
               <option value="Graphite">Graphite</option>
               <option value="Graphene">Graphene</option>
               <option value="Marble">Marble</option>
               <option value="Wax">Wax</option>
               <option value="Plaster">Plaster</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Address :</span>
            <input type="text"  name="flat" value="<?php echo $fetch_check['address']; ?>" required placeholder="Enter Address">
         </div>
      </div>
      <input type="submit" value="order now" class="btn" name="order_btn">
      <a href="cart.php" class="delete-btn">Go Back</a>
   </form>
   <?php
      }
   }
      ?>

</section>

<?php include 'footer.php'; ?>


<script src="js/script.js"></script>

</body>
</html>