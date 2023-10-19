<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){
   
   //if(isset($_COOKIE["usuario"])){
      $remember = $_POST['remember'];
   //}
   
   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   if(isset($_COOKIE["usuario"]) && $_COOKIE["usuario"] === $_POST['email']){
      $pass = mysqli_real_escape_string($conn,$filter_pass);
   }else{
      $pass = mysqli_real_escape_string($conn, md5($filter_pass));
   }
   

   $select_users = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE email = '$email' AND password = '$pass'") or die('la query falló');


   if(mysqli_num_rows($select_users) > 0){
      
      $row = mysqli_fetch_assoc($select_users);
      //Si hay cookie
      

      //if(isset[$_COOKIE["usuario"]])

      if(isset($remember)){
         setcookie("usuario",$row['email'],time()+(60*60));
         setcookie("password",$row['password'],time()+(60*60));
      }

      if($row['tipo'] == 'admin'){

         $_SESSION['admin_nombre'] = $row['nombre'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['tipo'] == 'user'){

         $_SESSION['user_nombre'] = $row['nombre'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         
         

         

         header('location:home.php');

      }else{
         $message[] = 'El usuario no existe!';
      }

   }else{
      $message[] = 'Mail o contraseña incorrecta!';
   }


}

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Iniciar Sesión </title>

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
      <h3>Ingresar</h3>
      <input type="email" name="email" id="email" class="box" placeholder="Ingresa tu correo" value= <?php if(isset($_COOKIE["usuario"])){ echo $_COOKIE["usuario"]; }?>>
      <input type="password" name="pass" id="pass" class="box" placeholder="Ingresa tu contraseña"  value= <?php if(isset($_COOKIE["usuario"])){ echo $_COOKIE["password"];}?>>
      <input type="submit" class="btn" name="submit" value="Ingresar">
      <p><input type="checkbox" name="remember" id="remember" <?php if(isset($_COOKIE["usuario"])){?> checked <?php }else{ ?> unchecked <?php } ?> >
      <label for="checkbox">Recordarme</label></p>
      <p>¿No tenés cuenta? <a href="registro.php">Registrate ahora</a> para recibir novedades. </p>
   </form>

</section>

<script src="js/validaciones.js"></script>

</body>
</html>