<?php

if(isset($_POST['title'])){

    require '../db_connect.php';

    $title = $_POST['title'];
    
    if(empty($title)){
        header("Location: ../todo.php?mess=error");
    } else{
        $stmt = $connect->prepare("INSERT INTO todos(title) VALUE(?)");
        $res = $stmt->execute([$title]);

        if($res){
            header("Location: ../todo.php?mess=success");
        }  else{
            header("Location: ../todo.php");
        }
        $connect = null;
        exit();
    }

} else{
    header("Location: ../todo.php?mess=error");
}