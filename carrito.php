<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `carrito` WHERE id = '$delete_id'") or die('la query falló');
    header('location:carrito.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `carrito` WHERE user_id = '$user_id'") or die('la query falló');
    header('location:carrito.php');
}; 

if(isset($_POST['actualizar_cantidad'])){
    $carrito_id = $_POST['carrito_id'];
    $carrito_cantidad = $_POST['carrito_cantidad'];
    mysqli_query($conn, "UPDATE `carrito` SET pcantidad = '$carrito_cantidad' WHERE id = '$carrito_id'") or die('la query falló');
    $message[] = 'carrito actualizado.';
}

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Carrito de compras</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Carrito de compras</h3>
    <p> <a href="home.php">home</a> / carrito de compras</p>
</section>

<section class="shopping-cart">

    <h1 class="titulo">Productos añadidos</h1>

    <div class="box-container">

    <?php
        $total_final = 0;
        $select_carrito = mysqli_query($conn, "SELECT * FROM `carrito` WHERE user_id = '$user_id'") or die('la query falló');
        if(mysqli_num_rows($select_carrito) > 0){
            while($fetch_carrito = mysqli_fetch_assoc($select_carrito)){
    ?>
    <div  class="box">
        <a href="carrito.php?delete=<?php echo $fetch_carrito['id']; ?>" class="fas fa-times" onclick="return confirm('Borrar del carrito?');"></a>
        <a href="view_page.php?pid=<?php echo $fetch_carrito['pid']; ?>" class="fas fa-eye"></a>
        <img src="uploaded_img/<?php echo $fetch_carrito['pimagen']; ?>" alt="" class="imagen">
        <div class="nombre"><?php echo $fetch_carrito['pnombre']; ?></div>
        <div class="precio">$<?php echo $fetch_carrito['pprecio']; ?>/-</div>
        <form action="" method="post">
            <input type="hidden" value="<?php echo $fetch_carrito['id']; ?>" name="carrito_id">
            <input type="number" min="1" value="<?php echo $fetch_carrito['pcantidad']; ?>" name="carrito_cantidad" class="qty">
            <input type="submit" value="actualizar" class="option-btn" name="actualizar_cantidad">
        </form>
        <div class="sub-total"> sub-total : <span>$<?php echo $sub_total = ($fetch_carrito['pprecio'] * $fetch_carrito['pcantidad']); ?>/-</span> </div>
    </div>
    <?php
    $total_final += $sub_total;
        }
    }else{
        echo '<p class="empty">Tu carrito está vacío.</p>';
    }
    ?>
    </div>

    <div class="more-btn">
        <a href="carrito.php?delete_all" class="delete-btn <?php echo ($total_final > 1)?'':'disabled' ?>" onclick="return confirm('¿Borrar el contenido?');">Borrar todo</a>
    </div>

    <div class="cart-total">
        <p>Total: <span>$<?php echo $total_final; ?>/-</span></p>
        <a href="shop.php" class="option-btn">Continuar comprando</a>
        <a href="checkout.php" class="btn  <?php echo ($total_final > 1)?'':'disabled' ?>">ir a pagar</a>
    </div>

</section>


<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>