<?php
session_start();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if($_POST['userName'] != "" && $_POST['passWord']!= ""){
    $userName = filter_var($_POST['userName'], FILTER_SANITIZE_SPECIAL_CHARS);
    $passWord = filter_var($_POST['passWord'], FILTER_SANITIZE_SPECIAL_CHARS);
    $hash_pass = sha1($passWord);
    
    $conn =  mysqli_connect('localhost','root','','storedb');

    if ($conn != false){

        $dbResult = mysqli_query($conn, 'SELECT * FROM users');
        $dbusers = mysqli_fetch_all($dbResult, MYSQLI_ASSOC);

        $user_exist = false;

        foreach($dbusers as $dbuser){

            
            if($userName == $dbuser["user"] && $hash_pass == $dbuser['password']){
                $user_exist = true;
                $_SESSION['id'] = $dbuser['id'];
                $_SESSION['role'] = $dbuser['role'];
                
                $_SESSION['cart']=[];
                mysqli_close($conn);
                echo 'done';
                
            }
        }
        if($user_exist == true && $_SESSION['role'] == 'admin'){

            header("Location: admin.php");
            exit;
        }
        if($user_exist == true && $_SESSION['role'] == ''){

            header("Location: store.php");
            exit;
        }

        elseif($user_exist == false){
            mysqli_close($conn);
            echo 'USERNAME OR PASSWORD IS NOT CORRECT';

        }

    }else{
        echo "DATABASE CONNECTION ERROR";
    }




    }else{
        echo "EMPTY VALUE IN INPUT FILED";
    }

    
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <label>User name</label>
        <input type="text" name="userName">

        <label>password</label>
        <input type="password" name="passWord">

        <input type="submit" name="submit" value="submit">
    </form>
    <p>create an account ?<a href="http://localhost:8080/PHPCOURSE/phpshop/registration.php">registration</a></p>
    
</body>
</html>