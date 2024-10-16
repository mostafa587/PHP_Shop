<?php
session_start();
if(isset($_SESSION['id']) && $_SESSION['id'] != ''){

    
    if(isset($_POST['logout'])){
        setcookie($_SESSION['id'],'', time() - 3600, "/");
        setcookie($_SESSION['id'],'', time() - 3600, "/PHPCOURSE/phpshop");
        session_unset();
        session_destroy();
        
        header("Location: login.php");
        exit;
    }

    if (isset($_POST['buy']) && $_POST['product'] != ''){

        if(isset($_COOKIE[$_SESSION['id']]) && !empty($_COOKIE[$_SESSION['id']])) {
            
            
            $_SESSION['cart'] = json_decode($_COOKIE[$_SESSION['id']], true);
        
        }
        
        // Add the product to the cart if it's not already there
        if (!in_array($_POST['product'], $_SESSION['cart'])) {
            $_SESSION['cart'][] = $_POST['product'];

            $jsonEncodedCart = json_encode($_SESSION['cart']);

            setcookie($_SESSION['id'], $jsonEncodedCart, time() + 3600, "/");
            setcookie($_SESSION['id'],'', time() - 3600, "/PHPCOURSE/phpshop");
            echo $_SESSION['cart'];
            header("Location: ".$_SERVER['PHP_SELF']);
            
        }

        
    }

    if (isset($_POST['cart_id']) && isset($_POST['REMOVE']) && $_POST['cart_id'] != '') {

        $_SESSION['cart'] = json_decode($_COOKIE[$_SESSION['id']], true);

        // Find the index of the product in the $_SESSION['cart'] array
        $index = array_search($_POST['cart_id'], $_SESSION['cart']);

        // Remove the product from the $_SESSION['cart'] array
        unset($_SESSION['cart'][$index]);

        // Encode the updated $_SESSION['cart'] array into a JSON string
        $jsonEncodedCart = json_encode($_SESSION['cart']);

        // Update the corresponding cookie with the new JSON string
        setcookie($_SESSION['id'], $jsonEncodedCart, time() + 3600);

        header("Location: ".$_SERVER['PHP_SELF']);

    
        
    }


}else{
    header("Location: login.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>store</title>
</head>
<body>

    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <input type="submit" name="logout" value="logout">

    </form>
    <table>

        <?php
        
        

            $conn = mysqli_connect('localhost','root','','storedb');
            if($conn != false){

                $result = mysqli_query($conn,"SELECT * FROM products");
                $dbproducts = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach($dbproducts as $dbproduct){
                    echo '<tr>';
                    echo '<td>' . $dbproduct['title'] . '</td>';
                    echo '<td><img width="50" height="50" src="http://localhost:8080/PHPCOURSE/phpshop/images/' . $dbproduct['image'] . '"></td>';
                    echo '<td>' . $dbproduct['price'] . '</td>';
                    echo '<td> <form method="POST"> <input type="hidden" name="product" value="'.$dbproduct['id'].'"> <input type="submit" name="buy" value="buy"> </form></td>';

                    echo '</tr>';

                }

                mysqli_close($conn);


            }else{
                echo "DATABASE ERROR";
            }


        ?>

    </table>
    <table>
        <?php
        
        if(isset($_COOKIE[$_SESSION['id']])){

            $productArray = json_decode($_COOKIE[$_SESSION['id']]);
            
            print_r($productArray);

        }

        

        $conn = mysqli_connect('localhost', 'root', '', 'storedb');
        if($conn != false && isset($_COOKIE[$_SESSION['id']]) ){

            

            foreach($productArray as $prod_id){
                $Result = mysqli_query($conn, "SELECT * FROM products WHERE id = '$prod_id'");
               
                $products = mysqli_fetch_all($Result, MYSQLI_ASSOC);
                
                echo '<tr>';
                echo '<td>' . $products[0]['title'] . '</td>';
                echo '<td><img width="50" height="50" src="http://localhost:8080/PHPCOURSE/phpshop/images/' . $products[0]['image'] . '"></td>';
                echo '<td>' . $products[0]['price'] . '</td>';
                echo '<td> <form method="POST"> <input type="hidden" name="cart_id" value="'.$products[0]['id'].'"> <input type="submit" name="REMOVE" value="REMOVE"> </form></td>';
                echo '</tr>';


                
            }
            mysqli_close($conn);

        }
        
        
        
        
        
        ?>
    </table>
    
    
</body>
</html>