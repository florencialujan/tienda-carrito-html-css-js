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

    <div class="flex">

        <a href="home.php" class="logo">agender.</a>

        <nav class="navbar">
            <ul>
                <li><a href="home.php">home</a></li>
                <li><a href="#">Nosotros</a>
                    <ul>
                        <li><a href="about.php">Nosotros</a></li>
                        <li><a href="contacto.php">Contactános</a></li>
                    </ul>
                </li>
                <li><a href="shop.php">Comprar</a></li>
                <li><a href="ordenes.php">Ordenes</a></li>
                <li><a href="#">Tu cuenta</a>
                    <ul>
                        <li><a href="login.php">login</a></li>
                        <li><a href="registro.php">registrarse</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="buscar.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
                $contar_prod_carrito = mysqli_query($conn, "SELECT * FROM `carrito` WHERE user_id = '$user_id'") or die('falló la query');
                $cart_num_rows = mysqli_num_rows($contar_prod_carrito);
            ?>
            <a href="carrito.php"><i class="fas fa-shopping-cart"></i><span>(<?php echo $cart_num_rows; ?>)</span></a>
        </div>

        <div class="account-box">
            <p>Usuario : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>Email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">salir</a>
        </div>

    </div>

</header>