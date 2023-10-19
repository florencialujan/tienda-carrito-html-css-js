<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sobre nosotros</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Nosotros</h3>
    <p> <a href="home.php">home</a> / Nosotros </p>
</section>

<section class="about">
    
    <div class="flex">
        <div class="content">
            <h3>¿Quienes somos?</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum odit voluptatum alias sed est in magni nihil nisi deleniti nostrum.</p>
        </div>

        <div class="imagen">
            <img src="images/about-img-1.png" alt="">
        </div>
    </div>

    <div class="flex">

        <div class="content">
            <h3>¿Donde nos podés encontrar?</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum odit voluptatum alias sed est in magni nihil nisi deleniti nostrum.</p>
            <a href="contacto.php" class="btn">Contactanos</a>
        </div>

        <div class="imagen">
            <img src="images/about-img-1.jpg" alt="">
        </div>

    </div>

    <div class="flex">

        <div class="imagen">
            <img src="images/about-img-2.jpg" alt="">
        </div>

        

    </div>

</section>


<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>