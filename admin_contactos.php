<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['borrar'])){
   $borrar_id = $_GET['borrar'];
   mysqli_query($conn, "DELETE FROM `mensajes` WHERE id = '$borrar_id'") or die('la query falló');
   header('location:admin_contactos.php');
}

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="messages">

   <h1 class="title">Mensajes recibidos</h1>

   <div class="box-container">

      <?php
       $select_message = mysqli_query($conn, "SELECT * FROM `mensajes`") or die('la query falló');
       if(mysqli_num_rows($select_message) > 0){
          while($fetch_message = mysqli_fetch_assoc($select_message)){
      ?>
      <div class="box">
         <p>id usuario : <span><?php echo $fetch_message['user_id']; ?></span> </p>
         <p>nombre : <span><?php echo $fetch_message['nombre']; ?></span> </p>
         <p>numero: <span><?php echo $fetch_message['email']; ?></span> </p>
         <p>email : <span><?php echo $fetch_message['numero']; ?></span> </p>
         <p>mensaje : <span><?php echo $fetch_message['mensaje']; ?></span> </p>
         <a href="admin_contactos.php?borrar=<?php echo $fetch_message['id']; ?>" onclick="return confirm('borrar el mensaje?');" class="delete-btn">borrar</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no tienes mensajes.</p>';
      }
      ?>
   </div>

</section>













<script src="js/admin_script.js"></script>

</body>
</html>