<?php
error_reporting(E_ALL);
session_start();
include 'db_connect.php';

if(isset($_SESSION['username'])){
    header('Location: login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if(!empty($username) && !empty($email) && !empty($password) && !empty($confirmPassword)){
        
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            
            if($password === $confirmPassword){
                
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                try{
                    $sql = "SELECT * FROM user_table WHERE username = :username OR email = :email";
                    $stmt = $connect->prepare($sql);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();

                    if($stmt->rowCount() == 0){
                        $sql = "INSERT INTO user_table (username, email, password) VALUES (:username, :email, :password)";
                        $stmt = $connect->prepare($sql);
                        $stmt->bindParam(':username', $username);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':password', $hashedPassword);
                        $stmt->execute();
                        header('Location: login.php');
                        echo "Register successful!";
                    } else{
                        echo "Username atau Email sudah digunakan.";
                    }
                } catch(PDOException $e){
                    echo "Error: " . $e->getMessage();
                }
            } else{
                echo "Password dan Confirm Password tidak sama.";
            }
        } else{
            echo "Email tidak valid.";
        }
    } else{
        echo "Semua kolom harus diisi.";
    }
}
?>


<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>Register</title>
</head>
<body>

    <img src="image/space.jpg">
    
    <div class="register">
        <h1>ToDo-List</h1>
        <h3>Please Enter Your Credential</h3>

        <form action="" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your Username" required>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Enter your E-mail" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>

            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Re-enter your Password" required>

            <div class="wrap">
                <button type="submit">Register</button>
            </div>
        </form>


        <p>Already have an account?
            <a href="login.php" style="text-decoration: none;">Log in</a>
        </p>

    </div>

    <script src="javascript/jquery-3.7.1.min.js"></script>

</body>
</html>