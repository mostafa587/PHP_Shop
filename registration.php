<?php



if(isset($_POST['userName']) && isset($_POST['passWord']) && isset($_POST['submit']) && $_POST['userName'] !== '' && $_POST['passWord'] !== ''){
    
    $userName = filter_var($_POST['userName'], FILTER_SANITIZE_SPECIAL_CHARS);
    $passWord = filter_var($_POST['passWord'], FILTER_SANITIZE_SPECIAL_CHARS);
    $hash_pass = sha1($passWord);
    $conn =  mysqli_connect('localhost','root','','storedb');

    if($conn != false){

        $dbResult = mysqli_query($conn, 'SELECT * FROM users');
        $dbusers = mysqli_fetch_all($dbResult, MYSQLI_ASSOC);

        $user_exist = false;
        
        
        foreach($dbusers as $dbuser){

            
            if($userName == $dbuser["user"]){
                $user_exist = true;
                mysqli_close($conn);
                echo 'THIS USERNAME IS ALREADY TAKEN PLS DADDY TYR ANOTHER :)';
                
                
            }
                
        }
        if($user_exist == false){
            mysqli_query($conn, "INSERT INTO users (user, password) VALUES ('$userName','$hash_pass')");
            echo "registration has done";
            mysqli_close($conn);
            header("Location: login.php");
            exit;
        }

        




    }else{
        echo "DATABASE CONNECTION ERROR";
    }
    
}elseif(isset($_POST['submit']) && ($_POST['userName'] == '' || $_POST['passWord'] == '' )){
echo "EMPTY VALUE IN INPUT FILED";
}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registration</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <label>User name</label>
        <input type="text" name="userName">

        <label>password</label>
        <input type="password" name="passWord">

        <input type="submit" name="submit" value="submit">
    </form>
    <p>already have account.<a href="http://localhost:8080/PHPCOURSE/phpshop/login.php">login</a></p>
    
</body>
</html>