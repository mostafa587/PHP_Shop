<?php
session_start();
if(isset($_SESSION['id']) && $_SESSION['role'] == 'admin'){
    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit;
    }

    if(isset($_POST['delete']) && $_POST['product'] != ''){
        $conn =  mysqli_connect('localhost','root','','storedb');
        $product_id = $_POST['product'];
        mysqli_query($conn,"DELETE FROM products WHERE id = '$product_id'");
        mysqli_close($conn);
    }

    if (isset($_POST['submit']) && $_POST['title'] !='' && $_POST['price'] !='' && $_POST['image'] !=''){

        $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
        $image = $_POST['image'];
        $price = filter_var($_POST['price'], FILTER_SANITIZE_SPECIAL_CHARS);
        

        $conn =  mysqli_connect('localhost','root','','storedb');
        if($conn != false){
        mysqli_query($conn, "INSERT INTO products (title, image, price) VALUES ('$title','$image','$price')");
        mysqli_close($conn);

        }else{
        echo 'DATABASE ERROR';
        exit;
        }

    }elseif(isset($_POST['submit'])){
        echo "input field is empty";
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
    <title>admin</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        

        <label>tittle</label>
        <input type="text" require name="title">

        <label>image</label>
        <input type="file" require name="image">

        <label>price</label>
        <input type="text" require name="price">

        <input type="submit" name="submit" value="submit">
    </form>

    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <input type="submit" name="logout" value="logout">

    </form>
    <table>
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'storedb');
    if ($conn != false) {
        $dbResult = mysqli_query($conn, 'SELECT * FROM products');
        $dbproducts = mysqli_fetch_all($dbResult, MYSQLI_ASSOC);
        foreach ($dbproducts as $dbproduct) {
            echo '<tr>';
            echo '<td>' . $dbproduct['title'] . '</td>';
            echo '<td><img width="50" height="50" src="http://localhost:8080/PHPCOURSE/phpshop/images/' . $dbproduct['image'] . '"></td>';
            echo '<td>' . $dbproduct['price'] . '</td>';
            echo '<td> <form method="POST"> <input type="hidden" name="product" value="'.$dbproduct['id'].'"> <input type="submit" name="delete" value="delete"> </form></td>';

            echo '</tr>';
        }
        mysqli_close($conn);
    }
    ?>
</table>

    
    
</body>
</html>