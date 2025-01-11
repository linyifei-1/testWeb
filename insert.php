<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增</title>
</head>
<body>
    <h1 align="center">新增</h1>
    <form action="insert.php" method="post" name="inf">
        <p align="center">学生学号：<input type="text" name="sid"/></p>
        <p align="center">学生名字：<input type="text" name="sn"/></p>
        <p align="center">学生性别：<input type="text" name="ss"/></p>
        <p align="center">学生年龄：<input type="text" name="sa"/></p>
        <p align="center"><input type="submit" name="insub" value="提交" /></p>
    </form>
    <?php
    session_start();
    $link = mysqli_connect('localhost','root','123456','webkeshe');
    if(!$link){
        exit('数据库连接失败！');
    }
    if(!empty($_POST["insub"])){
        $sid = $_POST['sid'];
        $sn = $_POST['sn'];
        $ss = $_POST['ss'];
        $sa = $_POST['sa'];
        mysqli_query($link,"INSERT INTO user (id,sname,ssex,age) VALUES ('$sid','$sn', '$ss', '$sa')");
        $_SESSION['yes']='添加成功！';
        header('location:mykeshe.php');
        exit;
    }
    ?>
</body>
</html>