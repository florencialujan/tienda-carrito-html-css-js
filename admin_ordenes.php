<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['actualizar_orden'])){
   $orden_id = $_POST['orden_id'];
   $actualizar_estado_pago = $_POST['actualizar_estado_pago'];
   mysqli_query($conn, "UPDATE `ordenes` SET estado = '$actualizar_estado_pago' WHERE id = '$orden_id'") or die('la query falló');
   $message[] = 'el estado fue actualizado.';
}

if(isset($_GET['borrar'])){
   $borrar_id = $_GET['borrar'];
   mysqli_query($conn, "DELETE FROM `ordenes` WHERE id = '$borrar_id'") or die('la query falló');
   header('location:admin_ordenes.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="placed-orders">

   <h1 class="title">ORDENES RECIBIDAS</h1>

   <div class="box-container">

      <?php
      
      $select_ordenes = mysqli_query($conn, "SELECT * FROM `ordenes`") or die('la query falló');
      if(mysqli_num_rows($select_ordenes) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_ordenes)){
      ?>
      <div class="box">
         <p> id usuario : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
         <p> fecha : <span><?php echo $fetch_orders['fecha']; ?></span> </p>
         <p> nombre : <span><?php echo $fetch_orders['nombre']; ?></span> </p>
         <p> numero : <span><?php echo $fetch_orders['numero']; ?></span> </p>
         <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> direccion : <span><?php echo $fetch_orders['direccion']; ?></span> </p>
         <p> total de productos : <span><?php echo $fetch_orders['total_productos']; ?></span> </p>
         <p> precio total : <span>$<?php echo $fetch_orders['precio_total']; ?>/-</span> </p>
         <p> Metodo de pago : <span><?php echo $fetch_orders['metodo']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="orden_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="actualizar_estado_pago">
               <option disabled selected><?php echo $fetch_orders['estado']; ?></option>
               <option value="pendiente">pendiente</option>
               <option value="completada">completada</option>
            </select>
            <input type="submit" name="actualizar_orden" value="update" class="option-btn">
            <a href="admin_ordenes.php?borrar=<?php echo $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Borrar esta orden?');">borrar</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No has recibido nuevas órdenes.</p>';
      }
      ?>
   </div>

</section>













<script src="js/admin_script.js"></script>

</body>
</html>