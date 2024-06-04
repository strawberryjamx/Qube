<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
   header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/about.css">
</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>About Us</h3>
      <p><a href="home.php">Home</a> / About</p>
   </div>

   <section class="about">
      <div class="container">
         <div class="content">
            <h3>About | Qube</h3>
            <p>Welcome to Qube, your destination for all things 3D printing and customization. 
               <br>
               <br>
               We are a passionate team dedicated to turning your ideas into reality. At Qube, we offer high-quality 3D printed products and custom designs that exceed your expectations. 
               <br>
               <br>
               From ready-to-order items to personalized creations, we cater to a wide range of interests and preferences. Our commitment to quality ensures that every item is visually stunning, durable, and reliable. 
               <br>
               <br>
               Welcome to the world of limitless possibilities at Qube. Start creating today!
               <br>
               <br>
               Join us in positively changing your life and the world around you.</p>
            <a href="contact.php" class="btn">Contact Us</a>
         </div>
      </div>
   </section>

   <section class="authors">
      <div class="container">
         <h1 class="title">Our Team</h1>
         <div class="box-container">
            <div class="box">
               <img src="images/author-1.jpg" alt="Author 1">
               <div class="share">
                  <a href="https://www.facebook.com/namuluisj" class="fab fa-facebook-f"></a>
                  <a href="#" class="fab fa-twitter"></a>
                  <a href="#" class="fab fa-instagram"></a>
               </div>
               <h3>Jamara Pucan</h3>
            </div>
            <div class="box">
               <img src="images/author-2.jpg" alt="Author 2">
               <div class="share">
                  <a href="https://www.facebook.com/april.dagdagan.37" class="fab fa-facebook-f"></a>
                  <a href="#" class="fab fa-twitter"></a>
                  <a href="#" class="fab fa-instagram"></a>
               </div>
               <h3>April Dagdagan</h3>
            </div>
            <div class="box">
               <img src="images/author-3.jpg" alt="Author 3">
               <div class="share">
                  <a href="https://www.facebook.com/angelgrace.peralta.96" class="fab fa-facebook-f"></a>
                  <a href="#" class="fab fa-twitter"></a>
                  <a href="#" class="fab fa-instagram"></a>
               </div>
               <h3>Angel Peralta</h3>
            </div>
         </div>
      </div>
   </section>

   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>
