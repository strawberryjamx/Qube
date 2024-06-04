<?php
session_start();
include 'config.php';

$message = [];

if (isset($_POST['submit'])) {
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, $_POST['password']);

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('Query failed');

   if (mysqli_num_rows($select_users) > 0) {
      $row = mysqli_fetch_assoc($select_users);

      if ($row['password'] == md5($pass)) {
         if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('Location: admin_page.php');
            exit();
         } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('Location: home.php');
            exit();
         }
      } else {
         $message[] = 'Incorrect password!';
      }
   } else {
      $message[] = 'User does not exist!';
   }
}

if (isset($_POST['register'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = mysqli_real_escape_string($conn, $_POST['number']);
   $address = mysqli_real_escape_string($conn, $_POST['address']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);
   $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('Query failed');

   if (mysqli_num_rows($select_users) > 0) {
      $message[] = 'User already exists!';
   } else {
      if ($password !== $confirm_password) {
         $message[] = 'Confirm password does not match!';
      } else {
         $hashed_password = md5($password); // Hash the password (consider using stronger hashing algorithms)
         mysqli_query($conn, "INSERT INTO `users` (name, email, address, number, password) VALUES ('$name', '$email', '$address', '$number', '$hashed_password')") or die('Query failed');
         $message[] = 'Registered successfully!';
         header('Location: login.php?register=success');
         exit();
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
   <title>Login</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/login.css">
</head>
<body>

<section class="form-container">
   <?php
   if (!empty($message)) {
      foreach ($message as $msg) {
         echo '
         <div class="message">
            <span>' . $msg . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }

   // Display registration success message
   if (isset($_GET['register']) && $_GET['register'] == 'success') {
      echo '
      <div>
         <span class="rs"><b>REGISTERED! You can now log in.</b></span>
         <i onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
   ?>

   <div class="container">
      <div class="welcome">
         <div class="pinkbox">
            <div class="signup nodisplay">
               <h1>Register</h1>
               <form autocomplete="off" method="POST">
                  <input type="text" placeholder="username" name="name">
                  <input type="email" placeholder="email" name="email">
                  <input type="text" placeholder="address" name="address" required>
                  <input type="text" placeholder="number" name="number">
                  <input type="password" placeholder="password" name="password">
                  <input type="password" placeholder="confirm password" name="confirm_password">
                  <button class="button submit" name="register">Create Account</button>
               </form>
            </div>
            <div class="signin">
               <h1>Sign in</h1>
               <form class="more-padding" autocomplete="off" method="POST">
                  <input type="email" placeholder="email" name="email">
                  <input type="password" placeholder="password" name="password">
                  <button class="button submit" name="submit">Login</button>
               </form>
            </div>
         </div>
         <div class="leftbox">
            <h2 class="title"><span>WELCOME</span><br></h2>
            <p class="desc">Pick your perfect <span class="msg">3D</span></p>
            <img class="cube " src="images/logo.png" border="0">
            <p class="account">Have an account?</p>
            <button class="button" id="signin">Login</button>
         </div>
         <div class="rightbox">
            <h2 class="title"><span>WELCOME</span><br></h2>
            <p class="desc"> Pick your perfect <span class="msg">3D</span></p>
            <img class="cube" src="images/logo.png"/>
            <p class="account">Don't have an account?</p>
            <button class="button" id="signup">Sign up</button>
         </div>
      </div>
   </div>

   <!-- jQuery CDN link -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

   <!-- Custom JavaScript file link -->
   <script src="js/login.js"></script>

</body>
</html>
