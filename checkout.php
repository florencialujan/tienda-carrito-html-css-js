<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['comprar'])){

    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $numero = mysqli_real_escape_string($conn, $_POST['numero']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $metodo = mysqli_real_escape_string($conn, $_POST['metodo']);
    $direccion = mysqli_real_escape_string($conn, 'piso no. '. $_POST['calle'].', '. $_POST['piso'].', '. $_POST['ciudad']. $_POST['cp']);
    $fecha = date('d-M-Y');

    $carrito_total = 0;
    $carrito_products[] = '';

    $carrito_query = mysqli_query($conn, "SELECT * FROM `carrito` WHERE user_id = '$user_id'") or die('la query falló');
    if(mysqli_num_rows($carrito_query) > 0){
        while($carrito_item = mysqli_fetch_assoc($carrito_query)){
            $carrito_products[] = $carrito_item['pnombre'].' ('.$carrito_item['pcantidad'].') ';
            $sub_total = ($carrito_item['pprecio'] * $carrito_item['pcantidad']);
            $carrito_total += $sub_total;
        }
    }

    $total_productos = implode(', ',$carrito_products);

    $comprar_query = mysqli_query($conn, "SELECT * FROM `ordenes` WHERE nombre = '$nombre' AND numero = '$numero' AND email = '$email' AND metodo = '$metodo' AND direccion = '$' AND total_productos = '$total_productos' AND precio_total = '$carrito_total'") or die('la query falló');

    if($carrito_total == 0){
        $message[] = 'tu carrito esta vacío!';
    }else if(mysqli_num_rows($comprar_query) > 0){
        $message[] = 'orden ya realizada!';
    }else{
        mysqli_query($conn, "INSERT INTO `ordenes`(user_id, nombre, numero, email, metodo, direccion, total_productos, precio_total, fecha) VALUES('$user_id', '$nombre', '$numero', '$email', '$metodo', '$direccion', '$total_productos', '$carrito_total', '$fecha')") or die('la query falló');
        mysqli_query($conn, "DELETE FROM `carrito` WHERE user_id = '$user_id'") or die('la query falló');
        $message[] = 'orden realizada correctamente!';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Vista previa</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Ver </h3>
    <p> <a href="home.php">home</a> / checkout </p>
</section>

<section class="display-order">
    <?php
        $precio_total = 0;
        $select_carrito = mysqli_query($conn, "SELECT * FROM `carrito` WHERE user_id = '$user_id'") or die('la query falló');
        if(mysqli_num_rows($select_carrito) > 0){
            while($fetch_carrito = mysqli_fetch_assoc($select_carrito)){
            $total_productos = ($fetch_carrito['pprecio'] * $fetch_carrito['pcantidad']);
            $precio_total += $total_productos;
    ?>    
    <p> <?php echo $fetch_carrito['pnombre'] ?> <span>(<?php echo '$'.$fetch_carrito['pprecio'].'/-'.' x '.$fetch_carrito['pcantidad']  ?>)</span> </p>
    <?php
        }
        }else{
            echo '<p class="empty">Tu carrito está vacio.</p>';
        }
    ?>
    <div class="grand-total">Total final : <span>$<?php echo $precio_total; ?>/-</span></div>
</section>

<section class="checkout">

    <form action="" method="POST">

        <h3>Registra tu orden</h3>

        <div class="flex">
            <div class="inputBox">
                <span>Nombre :</span>
                <input type="text" name="nombre" placeholder="Ingresa tu nombre">
            </div>
            <div class="inputBox">
                <span>Nro whatsapp:</span>
                <input type="number" name="numero" min="0" placeholder="Ingresa tu número de contacto">
            </div>
            <div class="inputBox">
                <span>Correo: :</span>
                <input type="email" name="email" placeholder="Ingresá tu email">
            </div>
            <div class="inputBox">
                <span>Metodo de pago :</span>
                <select name="metodo">
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta de débito/crédito</option>
                </select>
            </div>
            <div class="inputBox">
                <span>Calle y numero:</span>
                <input type="text" name="calle" placeholder="Por ej: Av. San Martin 242">
            </div>
            <div class="inputBox">
                <span>Otros datos</span>
                <input type="text" name="piso" placeholder="Por ej: Piso 3 depto 1">
            </div>
            <div class="inputBox">
                <span>Localidad :</span>
                <input type="text" name="ciudad" placeholder="Ingresa tu localidad">
            </div>
            <div class="inputBox">
                <span>Provincia :</span>
                <input type="text" name="state" placeholder="Ingresa tu provincia">
            </div>
            
            <div class="inputBox">
                <span>CP</span>
                <input type="number" min="0" name="cp" placeholder="Ingresa tu código postal">
            </div>
        </div>

        <input type="submit" name="comprar" value="Registrar pedido" class="btn">

    </form>

</section>






<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>