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

// 获取输入的学号
$studentId = $_POST['studentId'] ?? '';

// 防止 SQL 注入，使用预处理语句
$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->bind_param("s", $studentId);
$stmt->execute();
$result = $stmt->get_result();

// 美化页面的 HTML 和 CSS
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>论文审核情况</title>
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

        .info-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: left; /* 修改为左对齐 */
        }

        h1 {
            color: #333;
            text-align: center; /* 标题居中显示 */
        }

        p {
            color: #666;
            margin: 10px 0;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
        .green {
            color: green;
        }

        .red {
            color: red;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
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
        <li><a href="swelcome.php">首页</a></li>
            <li><a href="upload.html">论文提交</a></li>
            <li><a href="chatdate.html">查看论文审核情况</a></li>
            <li><a href="ssetupdate.html">修改个人信息</a></li>
            <li><a href="quit.html">退出登录</a></li>
        </ul>
    </div> 
    <div class="info-container">
        <?php
        if ($result->num_rows > 0) {
            // 输出用户信息
            $row = $result->fetch_assoc();
            $statusClass = ($row['状态'] == '通过') ? 'green' : 'red';
            $state="<span class='status $statusClass'>".$row['状态']."</span>";
            $address = '<a href="' . htmlspecialchars($row['file']) . '" target="_blank">' . htmlspecialchars($row['file']) . '</a>';
            echo "<h1>论文审核情况</h1>";
            echo "<p>学号: " . htmlspecialchars($row['id']) . "</p>";
            echo "<p>姓名: " . htmlspecialchars($row['sname']) . "</p>";
            echo "<p>论文题目: " . htmlspecialchars($row['title']) . "</p>";
            echo "<p>论文文件: " . $address . "</p>";
            echo "<p>审核状态: ".  $state ."</p>";
            echo "<p>审核意见: " . htmlspecialchars($row['remark']) . "</p>";
        } else {
            echo "<h1>未找到对应学号的用户信息。</h1>";
        }
        ?>
        <!-- 添加跳转到 upload.html 的按钮 -->
        <button onclick="location.href='upload.html'">重新提交</button>
        <p></p><button type='button' onclick='viewSubmissions($row["id"])'>查看提交记录</button>
    </div>
</body>
</html>
<?php
// 关闭连接
$stmt->close();
$conn->close();
?>
<script>
function viewSubmissions(studentId) {
    window.location.href = 'search_submissions.php?student_id=' + studentId;
}</script>