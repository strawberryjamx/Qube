<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">
            <img src="images/logo.png" alt="Qube Logo" style="height: 4rem;">
         </a>

         <nav class="navbar">
         <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li>
               <a href="#">Shop </a>
               <ul class="dropdown-content">
                  <li><a href="people_prod.php">People</a></li>
                  <li><a href="arch_prod.php">Architectural</a></li>
                  <li><a href="allprod.php">All products</a></li>
               </ul>
            </li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="orders.php">Orders</a></li>
         </ul>

         </nav>

         <div class="icons">
            <div id="menu-btn" class="menu-btn"></div>
            <a href="search_page.php" class="search-icon">
               <img src="images/search.png" alt="Search Icon" class="search-icon-img"></a>
            <div id="user-btn" class="user-icon">
               <a> <img src="images/user.png" alt="User Icon" class="user-icon-img"></a>
            </div>
            <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
            ?>
            <a href="cart.php"> <i class="cart-icon"></i>  
               <img src="images/cart.png" alt="Cart Icon" width="45" height="45" class="cart-icon-img">
               <span class="cart_num"><?php echo $cart_rows_number; ?></span>
            </a>
         </div>

         <div class="user-box">
            <p>username : <span><b><?php echo $_SESSION['user_name']; ?></b></span></p>
            <p>email : <span><b><?php echo $_SESSION['user_email']; ?></b></span></p>
            <a href="logout.php" class="delete-btn">logout</a>
         </div>
      </div>
   </div>

</header>