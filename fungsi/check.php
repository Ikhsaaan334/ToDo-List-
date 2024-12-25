<?php

if(isset($_POST['id'])){

    require '../db_connect.php';

    $id = $_POST['id'];
    
    if(empty($id)){
        echo 'error';
    } else{
        $todos = $connect->prepare("SELECT id, checked FROM todos WHERE id=?");

        $todos->execute([$id]);

        $todo = $todos->fetch();
        $uId = $todo['id'];
        $checked = $todo['checked'];

        $uChecked = $checked ? 0 : 1;

        $res = $connect->query("UPDATE todos SET checked=$uChecked WHERE id=$uId");

        if($res){
            echo $checked;
        } else{
            echo "ERROR";
        }

        $connect = null;
        exit();
    }

} else{
    header("Location: ../todo.php?mess=error");
}