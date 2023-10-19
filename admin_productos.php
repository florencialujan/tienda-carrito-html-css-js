<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['agregar_producto'])){

   $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
   $precio = mysqli_real_escape_string($conn, $_POST['precio']);
   $detalles = mysqli_real_escape_string($conn, $_POST['detalle']);
   $imagen = $_FILES['imagen']['name'];
   $size = $_FILES['imagen']['size'];
   $imagen_tmp_nombre = $_FILES['imagen']['tmp_name'];
   $image_folter = 'uploaded_img/'.$imagen;

   $select_nombre_producto = mysqli_query($conn, "SELECT nombre FROM `productos` WHERE nombre = '$nombre'") or die('la query falló');

   if(mysqli_num_rows($select_nombre_producto) > 0){
      $message[] = 'el nombre del producto ya existe!';
   }else{
      $insert_producto = mysqli_query($conn, "INSERT INTO `productos`(nombre, detalles, precio, imagen) VALUES('$nombre', '$detalles', '$precio', '$imagen')") or die('la query falló');

      if($insert_producto){
         if($size > 2000000){
            $message[] = 'el tamaño de la imagen es muy grande.';
         }else{
            move_uploaded_file($imagen_tmp_nombre, $image_folter);
            $message[] = 'se agregó el producto.';
         }
      }
   }

}

if(isset($_GET['borrar'])){

   $borrar_id = $_GET['borrar'];
   $select_borrar_imagen = mysqli_query($conn, "SELECT imagen FROM `productos` WHERE id = '$borrar_id'") or die('la query falló');
   $fetch_borrar_imagen = mysqli_fetch_assoc($select_borrar_imagen);
   unlink('uploaded_img/'.$fetch_borrar_imagen['imagen']);
   mysqli_query($conn, "DELETE FROM `productos` WHERE id = '$borrar_id'") or die('la query falló');
   mysqli_query($conn, "DELETE FROM `carrito` WHERE pid = '$borrar_id'") or die('la query falló');
   header('location:admin_productos.php');

}

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>productos</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="añadir-productos">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>agregar nuevo producto</h3>
      <input type="text" class="box" required placeholder="Ingresa el nombre" name="nombre">
      <input type="number" min="0" class="box" required placeholder="Ingresa el precio" name="precio">
      <textarea name="detalle" class="box" required placeholder="Detalles del producto" cols="30" rows="10"></textarea>
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="imagen">
      <input type="submit" value="agregar producto" name="agregar_producto" class="btn">
   </form>

</section>

<section class="mostrar-productos">

   <div class="box-container">
<!--ABM-->
      <?php
         $select_productos = mysqli_query($conn, "SELECT * FROM `productos`") or die('la query falló');
         if(mysqli_num_rows($select_productos) > 0){
            while($fetch_productos = mysqli_fetch_assoc($select_productos)){
      ?>
               <div class="box">
                  <div class="precio">$<?php echo $fetch_productos['precio']; ?>/-</div>
                  <img class="imagen" src="uploaded_img/<?php echo $fetch_productos['imagen']; ?>" alt="">
                  <div class="nombre"><?php echo $fetch_productos['nombre']; ?></div>
                  <div class="detalle"><?php echo $fetch_productos['detalles']; ?></div>
                  <a href="admin_actualizar_producto.php?actualizar=<?php echo $fetch_productos['id']; ?>" class="option-btn">actualizar</a>
                  <a href="admin_productos.php?borrar=<?php echo $fetch_productos['id']; ?>" class="delete-btn" onclick="return confirm('¿Desea borrar este producto?');">borrar</a>
               </div>
      <?php
            }
         }else{
            echo '<p class="empty">no has subido productos!</p>';
         }
      ?>
   </div>
   

</section>


<script src="js/admin_script.js"></script>

</body>
</html>