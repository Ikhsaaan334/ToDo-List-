<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dash.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>Dashboard</title>
</head>
<body>

    <img src="image/space.jpg">
    
    <div class="welcome">
        <h1>ToDo-List</h1>
        <?php
            session_start();
            if(isset($_SESSION['username'])){
                echo "<h3>Welcome, " . $_SESSION['username'] . "!</h3>";
            } else{
                header("Location: login.php");
                exit();
            }
        ?>
        <button onclick="window.location.href='todo.php'">Go to ToDo-List App</button>
        <form action="fungsi/signout.php" method="POST" style="display:inline;">
            <button type="submit">Logout</button>
        </form>
    </div>

    <script src="javascript/jquery-3.7.1.min.js"></script>

</body>
</html>
