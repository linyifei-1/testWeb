<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>删除</title>
</head>
<body>
    <?php
        $link = mysqli_connect('localhost','root','123456','webkeshe');
        if(!$link){
            exit('数据库连接失败！');
        }
        session_start();
        $del = $_SESSION['del'];
        mysqli_query($link,"DELETE from user where id = $del");
        unset($_SESSION['del']);    
        mysqli_close($link);
        header('location:mykeshe.php');
    ?>
</body>
</html>