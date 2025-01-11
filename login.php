<?php
session_start(); 
$username = $_POST["username"];
$password = $_POST["password"];

$conn = mysqli_connect("localhost", "root", "123456", "webkeshe");

$selectSQL = "SELECT class FROM login WHERE user='$username' AND password='$password'";

$result = mysqli_query($conn, $selectSQL);

if ($result) {
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        $_SESSION['username'] = $username;
        $row = mysqli_fetch_assoc($result);
        $class = $row['class'];
        if ($class == '1') {
            echo json_encode(array("error" => 1, "data" => "学生端登录成功！"));
        } elseif ($class == '2') {
            echo json_encode(array("error" => 2, "data" => "管理端登录成功！"));
        }
    } else {
        echo json_encode(array("error" => 0, "data" => "登录失败！"));
    }
} else {
    echo json_encode(array("error" => 0, "data" => "查询失败！"));
}
?>