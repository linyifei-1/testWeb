<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学生信息</title>
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

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 800px;
            max-width: 100%;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .status {
            color: red; /* 默认为红色 */
        }

        .status:contains('通过') {
            color: green; /* 状态为通过时为绿色 */
        }
        .green {
            color: green;
        }

        .red {
            color: red;
        }
        input[type="button"],
        input[type="submit"] {
            padding: 10px 15px;
            margin: 5px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        input[type="button"]:hover,
        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        input[type="text"] {
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .pagination {
        display: flex;
        justify-content: flex-end; /* 右对齐 */
        margin-top: 20px;
    }

    .pagination a {
        padding: 5px 10px;
        margin: 0 5px;
        background-color: #f2f2f2;
        color: #333;
        text-decoration: none;
        border-radius: 4px;
    }

    .pagination a:hover {
        background-color: #007bff;
        color: white;
    }

    .pagination span {
        padding: 5px 10px;
        background-color: #007bff;
        color: white;
        border-radius: 4px;
    }
    .search-container {
            display: flex;
            justify-content: flex-end; /* 右对齐 */
            align-items: center; /* 垂直居中 */
            margin-bottom: 20px; /* 添加一些底部间距 */
        }

        .search-container input[type="text"] {
            margin-right: 10px; /* 在输入框和按钮之间添加一些间距 */
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

    <div class="container">
    <h1 >论文提交情况</h1>
    <form action="" method="post" name="indexf">

        <div class="search-container">
                <input type="text" name="sel" />
                <input type="submit" value="搜索" name="selsub" />
            </div>
        <table align="center" border="1px" cellspacing="0px" width="800px">
            <tr><th>学号</th><th>姓名</th><th>论文题目</th><th>论文文件</th><th>提交时间</th><th>审核状态</th><th>评分</th><th>操作</th><th>审核意见</th></tr>
<?php
    session_start();
    if (isset($_SESSION['yes'])){
        echo'<p align="center">'.$_SESSION['yes'].'</p>';
        unset($_SESSION['yes']);
    }
    $link = mysqli_connect('localhost','root','123456','webkeshe');
    if(!$link){
        exit('数据库连接失败！');
    }

// 分页参数
$records_per_page = 10; // 每页显示的记录数
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // 当前页码

// 初始化搜索条件
$sel = isset($_POST['sel']) ? $_POST['sel'] : '';
$search_condition = $sel ? "WHERE id LIKE '%$sel%' OR sname LIKE '%$sel%' OR title LIKE '%$sel%' OR file LIKE '%$sel%' OR 状态 LIKE '%$sel%' OR remark LIKE '%$sel%'" : "";

// 计算总记录数
$total_records = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*) FROM user $search_condition"))[0];

// 计算总页数
$total_pages = ceil($total_records / $records_per_page);

// 计算 OFFSET
$offset = ($current_page - 1) * $records_per_page;

// 获取当前页的数据
$res = mysqli_query($link, "SELECT * FROM user $search_condition ORDER BY id ASC LIMIT $records_per_page OFFSET $offset");


    while ($row = mysqli_fetch_array($res)){
        $statusClass = ($row[4] == '通过') ? 'green' : 'red';
        echo '<tr align="center">';
        $address = '<a href="' . htmlspecialchars($row[3]) . '" target="_blank">' . htmlspecialchars($row[3]) . '</a>';

        echo "<td>$row[0]</td><td>$row[1]</td><td>$row[2]</td>";
        echo "<td> $address</td>";
        echo "<td>$row[6]</td>";
        echo "<td class='status $statusClass'>$row[4]</td>";
        echo "<td>
        <input type='text' name='score_{$row[0]}' value='" . htmlspecialchars($row[7]) . "' />
        <input type='submit' name='submit_score_{$row[0]}' value='提交评分' />
    </td>";
        echo "<td>
        <input type='submit' name='pass$row[0]' value='通过'/>
        <input type='submit' name='nopass$row[0]' value='不通过'/> 
        <input type='submit' name='delsub$row[0]' value='删除'/>
            <input type='button' name='edit_remark_$row[0]' value='编辑' onclick='toggleEdit(this, $row[0])' />
            <button type='button' onclick='viewSubmissions($row[0])'>提交记录</button>
        </td>
        <td id='remark_$row[0]_view'>$row[5]</td>
        <td id='remark_$row[0]_edit' style='display:none;'>
        <input type='text' name='remark_$row[0]' value='" . htmlspecialchars($row[5]) . "' />
        <input type='submit' name='update_remark_$row[0]' value='更新备注' />
        </td>";
        echo '</tr>';
        
        if (isset($_POST["pass$row[0]"])) {
            mysqli_query($link, "UPDATE user SET 状态='通过' WHERE id=$row[0]");
            header('location:mykeshe.php');
            
        }
        if (isset($_POST["nopass$row[0]"])) {
            mysqli_query($link, "UPDATE user SET 状态='不通过' WHERE id=$row[0]");
            header('location:mykeshe.php');
            
        }
        if(isset($_POST["delsub$row[0]"])){
            mysqli_query($link,"DELETE from user where id = $row[0]");
            // session_start();
            // $_SESSION['del']=$row[0];
            header('location:mykeshe.php');
            // echo '<script>
            //         if(confirm("是否删除？") == true){
            //             location.href="delet.php";
            //         }
            //         </script>';
            
            
        }
        
        // 处理备注更新
foreach ($row as $id => $value) {
    if (isset($_POST["update_remark_$id"])) {
        $newRemark = $_POST["remark_$id"];
        $updateRemarkQuery_log = "UPDATE submissions SET remarks='$newRemark' WHERE student_id=$id";
        mysqli_query($link, $updateRemarkQuery_log);
        
        $updateRemarkQuery = "UPDATE user SET remark='$newRemark' WHERE id=$id";
        if (mysqli_query($link, $updateRemarkQuery)) {
            echo "<script>alert('备注更新成功！'); window.location.href='mykeshe.php';</script>";
        } else {
            echo "<script>alert('备注更新失败！'); window.location.href='mykeshe.php';</script>";
        }
        exit;
    }
}
// 处理评分
foreach ($_POST as $key => $value) {
    if (strpos($key, 'submit_score_') === 0) {
        $id = substr($key, 13); // 提取学号
        $score = isset($_POST["score_$id"]) ? $_POST["score_$id"] : '';
        $updateScoreQuery = "UPDATE user SET score='$score' WHERE id=$id";
        if (mysqli_query($link, $updateScoreQuery)) {
            echo "<script>alert('评分成功！'); window.location.href='mykeshe.php';</script>";
        } else {
            echo "<script>alert('评分失败！'); window.location.href='mykeshe.php';</script>";
        }
        exit;
    }
}
    }

    // 显示分页导航
    echo '<div class="pagination">';
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current_page) {
            echo "<span>$i</span> ";
        } else {
            echo "<a href='mykeshe.php?page=$i'>$i</a> ";
        }
    }
    echo '</div>';
?>
        </table>
    </form>
    </div>
    <script>
function toggleEdit(button, id) {
    var viewCell = document.getElementById('remark_' + id + '_view');
    var editCell = document.getElementById('remark_' + id + '_edit');
    viewCell.style.display = 'none';
    editCell.style.display = 'table-cell';
    button.style.display = 'none';
}
function viewSubmissions(studentId) {
        window.location.href = 'search_submissions.php?student_id=' + studentId;
    }
</script>

</body>
</html>