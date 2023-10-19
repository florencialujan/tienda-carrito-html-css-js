<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['enviar'])){

    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $numero = mysqli_real_escape_string($conn, $_POST['numero']);
    $mensaje = mysqli_real_escape_string($conn, $_POST['mensaje']);

    $select_mensaje = mysqli_query($conn, "SELECT * FROM `mensajes` WHERE nombre = '$nombre' AND email = '$email' AND numero = '$numero' AND mensaje = '$mensaje'") or die('la query falló');

    if(mysqli_num_rows($select_mensaje) > 0){
        $message[] = 'El mensaje ya ha sido enviado!';
    }else{
        mysqli_query($conn, "INSERT INTO `mensajes`(user_id, nombre, email, numero, mensaje) VALUES('$user_id', '$nombre', '$email', '$numero', '$mensaje')") or die('la query falló');
        $message[] = 'mensaje enviado correctamente!';
    }

}

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Contactanos</h3>
    <p> <a href="home.php">home</a> / contacto </p>
</section>

<section class="contact">

    <form action="" method="POST">
        <h3>Envianos tu consulta!</h3>
        <input type="text" name="nombre" placeholder="Ingresa tu nombre" class="box" required> 
        <input type="email" name="email" placeholder="Ingresa tu email" class="box" required>
        <input type="number" name="numero" placeholder="Ingresa tu numero telefonico" class="box" required>
        <textarea name="mensaje" class="box" placeholder="Ingresa tu mensaje" required cols="30" rows="10"></textarea>
        <input type="submit" value="enviar mensaje" name="enviar" class="btn">
    </form>

</section>


<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>