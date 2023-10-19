<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};


if(isset($_POST['agregar_al_carrito'])){

    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $precio_producto = $_POST['precio_producto'];
    $imagen_producto = $_POST['imagen_producto'];
    $cantidad_producto = $_POST['cantidad_producto'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `carrito` WHERE pnombre = '$nombre_producto' AND user_id = '$user_id'") or die('la query falló');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'Producto ya añadido al carrito';
    }else{

        mysqli_query($conn, "INSERT INTO `carrito`(user_id, pid, pnombre, pprecio, pcantidad, pimagen) VALUES('$user_id', '$id_producto', '$nombre_producto', '$precio_producto', '$cantidad_producto', '$imagen_producto')") or die('la query falló');
        $message[] = 'Producto añadido al carrito';
    }

}

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Vista rápida</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="quick-view">

    <h1 class="title">Detalles del producto</h1>

    <?php  
        if(isset($_GET['pid'])){
            $pid = $_GET['pid'];
            $select_productos = mysqli_query($conn, "SELECT * FROM `productos` WHERE id = '$pid'") or die('la query falló');
         if(mysqli_num_rows($select_productos) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_productos)){
    ?>
    <form action="" method="POST">
         <img src="uploaded_img/<?php echo $fetch_products['imagen']; ?>" alt="" class="imagen">
         <div class="nombre"><?php echo $fetch_products['nombre']; ?></div>
         <div class="precio">$<?php echo $fetch_products['precio']; ?>/-</div>
         <div class="details"><?php echo $fetch_products['detalles']; ?></div>
         <input type="number" name="cantidad_producto" value="1" min="0" class="qty">
         <input type="hidden" name="id_producto" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="nombre_producto" value="<?php echo $fetch_products['nombre']; ?>">
         <input type="hidden" name="precio_producto" value="<?php echo $fetch_products['precio']; ?>">
         <input type="hidden" name="imagen_producto" value="<?php echo $fetch_products['imagen']; ?>">
         <input type="submit" value="agregar al carrito" name="agregar_al_carrito" class="btn">
      </form>
    <?php
            }
        }else{
        echo '<p class="empty">No encontrado.</p>';
        }
    }
    ?>

    <div class="more-btn">
        <a href="home.php" class="option-btn">Volver al comienzo</a>
    </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>