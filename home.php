<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}


if(isset($_POST['agregar_al_carrito'])){

   $id_producto = $_POST['id_producto'];
   $nombre_producto = $_POST['nombre_producto'];
   $precio_producto = $_POST['precio_producto'];
   $imagen_producto = $_POST['imagen_producto'];
   $cantidad_producto = $_POST['cantidad_producto'];

   $check_carrito = mysqli_query($conn, "SELECT * FROM `carrito` WHERE pnombre = '$nombre_producto' AND user_id = '$user_id'") or die('la query falló');

   if(mysqli_num_rows($check_carrito) > 0){
       $mensaje[] = 'Ya agregado.';
   }else{
       mysqli_query($conn, "INSERT INTO `carrito`(user_id, pid, pnombre, pprecio, pcantidad, pimagen) VALUES('$user_id', '$id_producto', '$nombre_producto', '$precio_producto', '$cantidad_producto', '$imagen_producto')") or die('la query falló');
       $mensaje[] = 'producto añadido al carrito';
   }

}

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="home">

   <div class="contenido">
      <h3>Nueva temporada</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime reiciendis, modi placeat sit cumque molestiae.</p>
   </div>

</section>

<section class="productos">

   <h1 class="titulo">Últimos productos</h1>

   <div class="box-container">

      <?php
         $select_productos = mysqli_query($conn, "SELECT * FROM `productos` LIMIT 6") or die('la query falló');
         if(mysqli_num_rows($select_productos) > 0){
            while($fetch_productos = mysqli_fetch_assoc($select_productos)){
               ?>
               <form action="" method="POST" class="box">
                  <a href="vista_producto.php?pid=<?php echo $fetch_productos['id']; ?>" class="fas fa-eye"></a>
                  <div class="precio">$<?php echo $fetch_productos['precio']; ?>/-</div>
                  <img src="uploaded_img/<?php echo $fetch_productos['imagen']; ?>" alt="" class="imagen">
                  <div class="nombre"><?php echo $fetch_productos['nombre']; ?></div>
                  <input type="number" name="cantidad_producto" value="1" min="0" class="qty">
                  <input type="hidden" name="id_producto" value="<?php echo $fetch_productos['id']; ?>">
                  <input type="hidden" name="nombre_producto" value="<?php echo $fetch_productos['nombre']; ?>">
                  <input type="hidden" name="precio_producto" value="<?php echo $fetch_productos['precio']; ?>">
                  <input type="hidden" name="imagen_producto" value="<?php echo $fetch_productos['imagen']; ?>">
                  <input type="submit" value="agregar al carrito" name="agregar_al_carrito" class="btn">
   
                  
               </form>
               <?php
            }
         }else{
            echo '<p class="empty">No hemos añadido productos todavía.</p>';
         }
      ?>

   </div>

   <div class="more-btn">
      <a href="shop.php" class="option-btn">Ver más</a>
   </div>

</section>

<section class="home-contact">

   <div class="contenido">
      <h3>¿Tenés preguntas?</h3>
      <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Distinctio officia aliquam quis saepe? Quia, libero.</p>
      <a href="contacto.php" class="btn">Contactanos</a>
   </div>

</section>




<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>