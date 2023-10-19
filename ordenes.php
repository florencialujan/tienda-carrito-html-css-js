<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Tus órdenes</h3>
    <p> <a href="home.php">Home</a> / Ordenes </p>
</section>

<section class="pedidos-realizados">

    <h1 class="titulo">Ordenes realizadas</h1>

    <div class="box-container">

    <?php
        $select_orders = mysqli_query($conn, "SELECT * FROM `ordenes` WHERE user_id = '$user_id'") or die('la query falló');
        if(mysqli_num_rows($select_orders) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
    ?>
    <div class="box">
        <p> Realizada el : <span><?php echo $fetch_orders['fecha']; ?></span> </p>
        <p> Nombre : <span><?php echo $fetch_orders['nombre']; ?></span> </p>
        <p> N° : <span><?php echo $fetch_orders['numero']; ?></span> </p>
        <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
        <p> Dirección : <span><?php echo $fetch_orders['direccion']; ?></span> </p>
        <p> Método de pago : <span><?php echo $fetch_orders['metodo']; ?></span> </p>
        <p> Tu orden : <span><?php echo $fetch_orders['total_productos']; ?></span> </p>
        <p> Precio total : <span>$<?php echo $fetch_orders['precio_total']; ?>/-</span> </p>
        <p> Estado del pago : <span style="color:<?php if($fetch_orders['estado'] == 'pendiente'){echo 'tomato'; }else{echo 'green';} ?>"><?php echo $fetch_orders['estado']; ?></span> </p>
    </div>
    <?php
        }
    }else{
        echo '<p class="vacio">no hay órdenes aún.</p>';
    }
    ?>
    </div>

</section>







<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>