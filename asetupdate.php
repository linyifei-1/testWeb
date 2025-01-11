<?php
session_start(); // 启动会话

// 检查是否已登录
if (!isset($_SESSION['username'])) {
    die("未登录或会话已过期，请重新登录。");
}

// 获取当前登录的用户名
$currentUsername = $_SESSION['username'];

// 获取新密码
if (isset($_POST['newPassword'])) {
    $newPassword = $_POST['newPassword'];
} else {
    die("未提供新密码。");
}

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

// 更新密码
$sql = "UPDATE login SET password = ? WHERE user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $newPassword, $currentUsername);

if ($stmt->execute()) {
    // 密码更新成功，跳转到登录页面
    echo "<script>alert('密码更新成功。'); window.location.href = 'asetupdate.html';</script>";
} else {
    // 密码更新失败
    echo "<script>alert('密码更新失败: " . $stmt->error . "'); window.location.href = 'asetupdate.html';</script>";
}

$stmt->close();
$conn->close();
?>