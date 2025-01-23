<?php
require 'db_connect.php';
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/todo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>ToDO-List</title>
</head>
<body>
    
    <img src="image/space.jpg">

    <div class="back-button">
        <button onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
    </div>
    
    <div class="main-section">
        <h1>ToDo-List</h1>
        <div class="add-section">
        <form action="fungsi/add.php" method="POST" autocomplete="off">
            <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                <input type="text" name="title" style="border-color:rgb(255, 0, 0)" placeholder="Require an input"/>
                <button type="submit">Add &nbsp; <span>&#43;</span></button>
            <?php } else{ ?>
                <input type="text" name="title" placeholder="Enter your Activities Here"/>
                <button type="submit">Add &nbsp; <span>&#43;</span></button>
            <?php } ?>
        </form>
        </div>
        <?php
            $todos = $connect->query("SELECT * FROM todos ORDER BY id DESC");
        ?>
        <div class="show-section">
            <?php if($todos->rowCount() <= 0){ ?>
                <div class="todo-item">
                    <div class="empty">
                        <h1>ここは何も</h1>
                    </div>
                </div>
            <?php } ?>

            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <span id="<?php echo $todo['id']; ?>"
                                class="remove-todo">x</span>
                    <?php if($todo['checked']) { ?>
                        <input type="checkbox" data-todo-id="<span id="<?php echo $todo['id']; ?> id="check" class="checkbox"  checked />
                        <h2 class="checked"><?php echo $todo['title'] ?></h2>
                    <?php } else{ ?>
                        <input type="checkbox" data-todo-id="<span id="<?php echo $todo['id']; ?>" id="check" class="checkbox"/>
                        <h2><?php echo $todo['title'] ?></h2>
                    <?php } ?>
                    <br>
                    <small>created <?php echo $todo['date'] ?></small>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="javascript/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.remove-todo').click(function(){
                const id = $(this).attr('id');

                $.post("fungsi/remove.php",
                    {
                        id: id
                    },
                    (data) => {
                        if(data){
                            $(this).parent().hide(600);
                        }
                    }
                );

            });
            $(".checkbox").click(function(e){
                const id = $(this).attr('data-todo-id');

                $.post('fungsi/check.php',
                    {
                        id: id
                    },
                    (data) => {
                        if(data != 'ERROR'){
                            const h2 = $(this).next();
                            if(data === '1'){
                                h2.removeClass('checked');
                            } else{
                                h2.addClass('checked');
                            }
                        }
                    }
                );
            });
        });
    </script>

</body>
</html>