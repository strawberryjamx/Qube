<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name' AND user_id = '$user_id'");

    if (!$check_cart_numbers) {
        die('Query failed: ' . mysqli_error($conn));
    }

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
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
   <title>home</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/home.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">
    <div class="content">
        <h3>We want to hand your ideas to your hands</h3>
        <p>Turning your ideas into reality.</p>
    </div>
</section>

<section class="products">
    <h1 class="title">Latest Products</h1>
    <div class="box-container">

        <?php
        $limit = 3; // Set the limit to 3 products

        // Retrieve 3 products from the `allprod.php` file
        // Retrieve 3 products from the `allprod` table
        $select_people_products = mysqli_query($conn, "SELECT name, description, price, image FROM `people_prod` LIMIT $limit") or die('Query failed for retrieving people products');

        $select_arch_products = mysqli_query($conn, "SELECT name, description, price, image FROM `arch_prod` LIMIT $limit") or die('Query failed for retrieving arch products');
        
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
        
        // Display products
        // Display products
// Display products
if (!empty($products)) {
    $counter = 0; // Initialize a counter variable
    foreach ($products as $product) {
        $counter++; // Increment the counter
        if ($counter > $limit) {
            break; // Break the loop if the counter exceeds the limit
        }
        ?>
        <div class="box">
            <img class="image" src="uploaded_img/<?php echo $product['image']; ?>" alt="">
            <div class="name"><?php echo $product['name']; ?></div>
            <div class="description"><?php echo $product['description']; ?></div>
            <div class="price">₱<?php echo $product['price']; ?></div>
            <form method="POST" action="">
                <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">
                <input type="number" name="product_quantity" value="1" min="1" class="qty">
                <button type="submit" name="add_to_cart" class="btn1">Add to Cart</button>
            </form>
        </div>
        <?php
    }
} else {
    echo '<p class="empty">No products added yet!</p>';
}


        

        ?>
    </div>

    <?php
    $total_products_people = mysqli_num_rows(mysqli_query($conn, "SELECT name, description, price, image FROM `people_prod`"));
    $total_products_arch = mysqli_num_rows(mysqli_query($conn, "SELECT name, description, price, image FROM `arch_prod`"));
    
    $total_products = $total_products_people + $total_products_arch;
    
    if ($total_products > $limit) {
        ?>
        <div class="load-more" style="margin-top: 2rem; text-align:center">
            <a href="allprod.php" class="white-btn1">Load More</a>
        </div>
        <?php
    }
    ?>
</section>

<section class="about">
<div class="flex">

        <div class="image">
            <img src="images/about-img.webp" alt="">
        </div>

        <div class="content">
            <h3>About Us</h3>
            <p>Welcome to Qube, your destination for all things 3D printing and customization. We are a passionate team dedicated to turning your ideas into reality.</p>
            <a href="about.php" class="white-btn1">Read More</a>
        </div>
</section>

<section class="about">
   <div class="flex">
      <div class="content">
         <h3>Need assistance?</h3>
         <p>Get in touch with us to discuss your design preferences and ask any questions you may have.</p>
         <a href="contact.php" class="white-btn1">Contact Us</a>
      </div>

      <div class="img">
            <img src="images/about-img.gif" alt="">
        </div>
   </div>
</section>







<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>