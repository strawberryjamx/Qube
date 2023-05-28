<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

$select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
$fetch_check = mysqli_fetch_assoc($select_user);

if (isset($_POST['send'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = $_POST['number'];
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   // File upload handling
   $file = $_FILES['picture'];
   $filename = $file['name'];
   $filetmp = $file['tmp_name'];
   $filesize = $file['size'];
   $filetype = $file['type'];
   $fileerror = $file['error'];

   $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

   // Check if a file was uploaded
   if ($filename != '') {
      // Get the file extension
      $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

      // Check if the file extension is allowed
      if (in_array($ext, $allowedExtensions)) {
         // Generate a unique filename to avoid conflicts
         $newFilename = uniqid('upload_', true) . '.' . $ext;

         // Define the target directory to save the file
         $targetDir = 'uploads/';

         // Check if the target directory exists, create it if not
         if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
         }

         // Move the uploaded file to the target directory
         $targetPath = $targetDir . $newFilename;
         move_uploaded_file($filetmp, $targetPath);

         // Insert the filename into the database
         mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message, picture) VALUES('$user_id', '$name', '$email', '$number', '$msg', '$newFilename')") or die('query failed');

         $message[] = 'Message sent successfully!';
      } else {
         $message[] = 'Invalid file format! Only JPG, JPEG, PNG, and GIF files are allowed.';
      }
   } else {
      // Insert the message without the picture if no file was uploaded
      mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');

      $message[] = 'Message sent successfully!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      /* Custom styles for minimalistic design */
      body {
         font-family: Arial, sans-serif;
         margin: 0;
         padding: 0;
         background-color: #f2f2f2;
      }

      .heading {
         background-color: #333;
         color: #fff;
         padding: 1rem;
         text-align: center;
      }

      .heading h3 {
         margin: 0;
         font-size: 2.5rem;
         text-transform: uppercase;
      }

      .heading p {
         margin: 0;
         font-size: 2rem;
         color: #ccc;
      }

      .container {
         max-width: 1000px;
         margin: 0 auto;
         padding: 2rem;
         background-color: #fff;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
         border-radius: 4px;
         margin-top: 2rem;
         margin-bottom: 2rem;
      }

      .container form {
         text-align: center;
      }

      .container h3 {
         font-size: 2rem;
         margin-bottom: 1rem;
      }

      .container p {
         Font family: "Open Sans", Arial, sans-serif;
         font-size: 1.5rem;
         text-align: left;
         margin-bottom: 1rem;
         color: #666666;
      }

      .container .box {
         width: 100%;
         border: 1px solid #ccc;
         padding: 1rem;
         font-size: 1.6rem;
         margin-bottom: 1.5rem;
         border-radius: 4px;
         transition: border-color 0.3s ease;
      }

      .container .box:focus {
         outline: none;
         border-color: #666;
      }

      .container .box[type="submit"] {
         background-color: #333;
         color: #fff;
         cursor: pointer;
      }

      .container .box[type="submit"]:hover {
         background-color: #555;
      }

      .container .error-message {
         color: red;
         margin-bottom: 1rem;
      }

      .container .success-message {
         color: green;
         margin-bottom: 1rem;
      }
   </style>

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Contact Us</h3>
      <p> <a href="home.php">Home</a> / Contact</p>
   </div>

   <div class="container">

      <form action="" method="post" enctype="multipart/form-data">
         <?php
         if (isset($message)) {
            foreach ($message as $msg) {
               echo "<div class='success-message'>$msg</div>";
            }
         }
         ?>
         <h3>Say Something!</h3>
         <p>Have questions or a custom request? Please send me a message below or an e-mail at phservice@qubemail.com.
            <br>
            <br>
            I would love to hear from you and will usually respond within 24 hours.
            <br>
            <br>
            ~ Qube
         </p>
         <input type="text" name="name" value="<?php echo $fetch_check['name']; ?>" required placeholder="Enter your name" class="box">
         <input type="email" name="email" value="<?php echo $fetch_check['email']; ?>" required placeholder="Enter your email" class="box">
         <input type="tel" name="number" required placeholder="Enter your number" class="box">
         <textarea name="message" class="box" placeholder="Enter your message" cols="30" rows="10"></textarea>
         <input type="file" name="picture" accept="image/*" class="box">
         <input type="submit" value="Send Message" name="send" class="box" style="background-color: #333; color: #fff; cursor: pointer;">
      </form>

   </div>

   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>
