<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<?php
    session_start();
    include 'db_connect.php';
    
    if(isset($_SESSION['username'])){
        header('Location: dashboard.php');
        exit();
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        try {
            $sql = "SELECT * FROM user_table WHERE username = :username";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $user['password'])) {
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['id'] = $user['id'];
                    header("Location: dashboard.php");
                    exit();
                } else{
                    echo "Wrong Password";
                }
            } else{
                echo "Username not found";
            }
        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }
?>

<body>

    <img src="image/space.jpg">
    
    <div class="login">
        <h1>ToDo-List</h1>
        <h3>Please Enter Your Account</h3>

        <form action="" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your Username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>

            <div class="wrap">
                <button type="submit" name="login">Login</button>
            </div>
        </form>


        <p>Not registered?
            <a href="register.php" style="text-decoration: none;">
                Create an account
            </a>
        </p>

    </div>

    <script src="javascript/jquery-3.7.1.min.js"></script>

</body>
</html>