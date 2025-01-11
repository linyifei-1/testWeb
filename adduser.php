<?php
// 数据库连接信息
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "webkeshe";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 获取用户输入
$user = $_POST['user'] ?? '';
$password = $_POST['password'] ?? '';
$class = $_POST['class'] ?? '1'; // 默认为普通用户

// 防止 SQL 注入，使用预处理语句
$stmt = $conn->prepare("INSERT INTO login (user, password, class) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $user, $password, $class);

if ($stmt->execute()) {
    // 用户添加成功
    echo "<script>alert('用户添加成功！'); window.location.href = 'adduser.html';</script>";
} else {
    // 用户添加失败
    echo "<script>alert('用户添加失败: " . $stmt->error . "'); window.location.href = 'adduser.html';</script>";
}

// 关闭连接
$stmt->close();
$conn->close();
?>