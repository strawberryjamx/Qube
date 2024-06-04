<?php
include 'config.php';

$select_people_products = mysqli_query($conn, "SELECT * FROM `people_prod`") or die('Query failed for people_prod table');
$select_arch_products = mysqli_query($conn, "SELECT * FROM `arch_prod`") or die('Query failed for arch_prod table');

$products = array();

if (mysqli_num_rows($select_people_products) > 0) {
    while ($fetch_people_products = mysqli_fetch_assoc($select_people_products)) {
        $product = array(
            'name' => $fetch_people_products['name'],
            'description' => $fetch_people_products['description'],
            'price' => $fetch_people_products['price'],
            'image' => $fetch_people_products['image']
        );
        $products[] = $product;
    }
}

if (mysqli_num_rows($select_arch_products) > 0) {
    while ($fetch_arch_products = mysqli_fetch_assoc($select_arch_products)) {
        $product = array(
            'name' => $fetch_arch_products['name'],
            'description' => $fetch_arch_products['description'],
            'price' => $fetch_arch_products['price'],
            'image' => $fetch_arch_products['image']
        );
        $products[] = $product;
    }
}

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

if (isset($_POST['add_to_cart'])) {
   $product_name = $_POST['product_name'];
   $product_description = $_POST['product_description'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die(mysqli_error($conn));

   if (mysqli_num_rows($check_cart_numbers) > 0) {
      $message[] = 'already added to cart!';
   } else {
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, description, price, image, quantity) VALUES('$user_id', '$product_name', '$product_description', '$product_price', '$product_image', '$product_quantity')") or die('Query failed for inserting into cart table');
      $message[] = 'Product added to cart!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Our Shop</h3>
   <p><a href="home.php">Home</a> / Shop</p>
</div>

<section class="products">

   <h1 class="title">All Products</h1>

   <div class="box-container">

   <?php  
            if (!empty($products)) {
               foreach ($products as $product) {
         ?>
         <form action="" method="post" class="box">
         <img class="image" src="uploaded_img/<?php echo $product['image']; ?>" alt="">
         <div class="name"><?php echo $product['name']; ?></div>
         <div class="description"><?php echo $product['description']; ?></div>
         <div class="price">₱<?php echo $product['price']; ?></div>
         <input type="number" min="1" name="product_quantity" value="1" class="qty">
         <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
         <input type="hidden" name="product_description" value="<?php echo $product['description']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">
         <input type="submit" value="Add to Cart" name="add_to_cart" class="btn1">
      </form>
      <?php
            }
         } else {
            echo '<p class="empty">No products added yet!</p>';
         }
      ?>
   </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
