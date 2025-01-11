<?php
session_start(); // 启动会话

if (!isset($_SESSION['username'])) {
    header('Location: login.html'); // 如果未登录，重定向到登录页面
    exit;
}

$currentUsername = $_SESSION['username']; // 获取当前登录的用户名
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>欢迎页面</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .welcome-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
        }

        p {
            color: #666;
            font-size: 16px;
        }

        .logout-button {
            display: block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }

        .logout-button:hover {
            background-color: #0056b3;
        }
        .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 200px;
    height: 100%;
    background-color: #333;
    color: white;
    padding: 20px;
    box-sizing: border-box;
}

.sidebar h2 {
    margin-bottom: 20px;
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
}

.sidebar ul li {
    margin-bottom: 10px;
}

.sidebar ul li a {
    color: white;
    text-decoration: none;
    font-size: 16px;
}

.sidebar ul li a:hover {
    text-decoration: underline;
}

.container {
    margin-left: 220px; /* 为菜单栏留出空间 */
    width: calc(100% - 220px); /* 调整容器宽度 */
}
    </style>
</head>
<body>
<div class="sidebar">
        <h2>菜单</h2>
        <ul>
            <li><a href="awelcome.php">首页</a></li>
            <li><a href="mykeshe.php">论文提交情况</a></li>
            <li><a href="adduser.html">添加用户</a></li>
            <li><a href="asetupdate.html">修改个人信息</a></li>
            <li><a href="quit.html">退出登录</a></li>
        </ul>
    </div>
    <div class="welcome-container">
        <h1>欢迎，<?php echo htmlspecialchars($currentUsername); ?>!</h1>
        <p>您已成功登录。</p>
        <a href="quit.html" class="logout-button">退出登录</a>
    </div>
</body>
</html>