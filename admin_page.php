<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="panel">

   <h1 class="titulo">panel</h1>

   <div class="box-container">

      <div class="box">
         <?php
            $total_pendings = 0;
            $select_pendings = mysqli_query($conn, "SELECT * FROM `ordenes` WHERE estado = 'pending'") or die('la query falló');
            while($fetch_pendings = mysqli_fetch_assoc($select_pendings)){
               $total_pendings += $fetch_pendings['precio_total'];
            };
         ?>
         <h3>$<?php echo $total_pendings; ?>/-</h3>
         <p>total pendientes</p>
      </div>

      <div class="box">
         <?php
            $total_completas = 0;
            $seleccionar_completas = mysqli_query($conn, "SELECT * FROM `ordenes` WHERE estado = 'completed'") or die('la query falló');
            while($fetch_completas = mysqli_fetch_assoc($seleccionar_completas)){
               $total_completas += $fetch_completas['precio_total'];
            };
         ?>
         <h3>$<?php echo $total_completas; ?>/-</h3>
         <p>Pagos realizados</p>
      </div>

      <div class="box">
         <?php
            $select_ordenes = mysqli_query($conn, "SELECT * FROM `ordenes`") or die('la query falló');
            $cantidad_ordenes = mysqli_num_rows($select_ordenes);
         ?>
         <h3><?php echo $cantidad_ordenes; ?></h3>
         <p>pedidos</p>
      </div>

      <div class="box">
         <?php
            $select_productos = mysqli_query($conn, "SELECT * FROM `productos`") or die('la query falló');
            $cantidad_productos = mysqli_num_rows($select_productos);
         ?>
         <h3><?php echo $cantidad_productos; ?></h3>
         <p>productos añadidos</p>
      </div>

      <div class="box">
         <?php
            $select_usuarios = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE tipo = 'user'") or die('la query falló');
            $cantidad_usuarios = mysqli_num_rows($select_usuarios);
         ?>
         <h3><?php echo $cantidad_usuarios; ?></h3>
         <p>clientes</p>
      </div>

      <div class="box">
         <?php
            $select_admin = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE tipo = 'admin'") or die('la query falló');
            $cantidad_admins = mysqli_num_rows($select_admin);
         ?>
         <h3><?php echo $cantidad_admins; ?></h3>
         <p>administradores</p>
      </div>

      <div class="box">
         <?php
            $select_cuentas = mysqli_query($conn, "SELECT * FROM `usuarios`") or die('la query falló');
            $cantidad_cuentas = mysqli_num_rows($select_cuentas);
         ?>
         <h3><?php echo $cantidad_cuentas; ?></h3>
         <p>total de cuentas</p>
      </div>

      <div class="box">
         <?php
            $select_mensajes = mysqli_query($conn, "SELECT * FROM `mensajes`") or die('la query falló');
            $cantidad_mensajes = mysqli_num_rows($select_mensajes);
         ?>
         <h3><?php echo $cantidad_mensajes; ?></h3>
         <p>mensajes</p>
      </div>

   </div>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>