<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['actualizar_producto'])){

   $update_p_id = $_POST['update_p_id'];
   $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
   $precio = mysqli_real_escape_string($conn, $_POST['precio']);
   $detalles = mysqli_real_escape_string($conn, $_POST['detalles']);
   
   mysqli_query($conn, "UPDATE `productos` SET nombre = '$nombre', detalles = '$detalles', precio = '$precio' WHERE id = '$update_p_id'") or die('la query falló');

   $imagen = $_FILES['imagen']['name'];
   $imagen_size = $_FILES['imagen']['size'];
   $imagen_tmp_nombre = $_FILES['imagen']['tmp_name'];
   $imagen_folter = 'uploaded_img/'.$imagen;
   $imagen_anterior = $_POST['update_p_imagen'];
   
   if(!empty($imagen)){
      if($imagen_size > 2000000){
         $message[] = 'el tamaño de la imagen es muy grande.';
      }else{
         mysqli_query($conn, "UPDATE `productos` SET imagen = '$imagen' WHERE id = '$update_p_id'") or die('la query falló');
         move_uploaded_file($imagen_tmp_nombre, $imagen_folter);
         unlink('uploaded_img/'.$imagen_anterior);
         $message[] = 'se actualizó la imagen.';
      }
   }

   $message[] = 'se actualizó el producto correctamente.';

}

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>actualizar producto</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="actualizar-producto">

<?php

   $update_id = $_GET['actualizar'];
   $select_productos = mysqli_query($conn, "SELECT * FROM `productos` WHERE id = '$update_id'") or die('la query falló');
   if(mysqli_num_rows($select_productos) > 0){
      while($fetch_productos = mysqli_fetch_assoc($select_productos)){
?>

      <form action="" method="post" enctype="multipart/form-data">
         <img src="uploaded_img/<?php echo $fetch_productos['imagen']; ?>" class="imagen"  alt="">
         <input type="hidden" value="<?php echo $fetch_productos['id']; ?>" name="update_p_id">
         <input type="hidden" value="<?php echo $fetch_productos['imagen']; ?>" name="update_p_imagen">
         <input type="text" class="box" value="<?php echo $fetch_productos['nombre']; ?>" required placeholder="actualizar nombre" name="nombre">
         <input type="number" min="0" class="box" value="<?php echo $fetch_productos['precio']; ?>" required placeholder="ingresa el nuevo precio" name="precio">
         <textarea name="detalles" class="box" required placeholder="actualizar detalles" cols="30" rows="10"><?php echo $fetch_productos['detalles']; ?></textarea>
         <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="imagen">
         <input type="submit" value="actualizar producto" name="actualizar_producto" class="btn">
         <a href="admin_productos.php" class="option-btn">volver</a>
      </form>

<?php
      }
   }else{
      echo '<p class="empty">no se han encontrado coincidencias</p>';
   }
?>

</section>


<script src="js/admin_script.js"></script>

</body>
</html>