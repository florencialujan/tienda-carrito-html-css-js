<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $filter_name = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
   $name = mysqli_real_escape_string($conn, $filter_name);
   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));
   $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
   $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));

   $select_users = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE email = '$email'") or die('la query falló');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'El usuario ya existe.';
   }else{
      if($pass != $cpass){
         $message[] = 'Password incorrecta';
      }else{
         mysqli_query($conn, "INSERT INTO `usuarios`(nombre, email, password) VALUES('$name', '$email', '$pass')") or die('la query falló');
         $message[] = 'Te registraste correctamente!';
         header('location:login.php');
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Registrate</title>
   

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

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
   
<section class="form-container">

   <form action="" method="post" id="form">
      <h3>Registrate ahora mismo</h3>
      <input type="text" name="nombre" class="box" placeholder="Ingresa tu usuario">
      <input name="email" class="box" id="email" placeholder="Ingresa tu email">
      <input type="password" name="pass" id="pass" class="box" placeholder="Ingresa tu contraseña">
      <input type="password" name="cpass" class="box" placeholder="Confirma tu contraseña">
      <input type="submit" class="btn" name="submit" id="submit" value="Registrarse">
      <p>¿Ya tenés cuenta? <a href="login.php">Ingresá aqui.</a></p>
   </form>

</section>

<script src="js/validaciones.js"></script>

</body>
</html>