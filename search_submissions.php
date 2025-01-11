<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>论文提交记录</title>
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

        .search-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            margin-right: 10px;
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .search-container input[type="submit"] {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .search-container input[type="submit"]:hover {
            background-color: #0056b3;
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

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a, .pagination span {
            padding: 5px 10px;
            margin: 0 5px;
            background-color: #f2f2f2;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
        }

        .pagination a:hover, .pagination span {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>论文提交记录</h1>
        <form action="" method="post" name="indexf">
            <div class="search-container">
                <input type="text" name="sel" placeholder="搜索学号、姓名、论文题目等" />
                <input type="submit" value="搜索" name="selsub" />
            </div>
            <table align="center" border="1px" cellspacing="0px" width="800px">
                <tr>
                    <th>学号</th>
                    <th>姓名</th>
                    <th>论文题目</th>
                    <th>论文文件</th>
                    <th>提交时间</th>
                    <th>审核意见</th>
                </tr>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "123456";
                $dbname = "webkeshe";

                // 创建数据库连接
                $link = mysqli_connect('localhost', 'root', '123456', 'webkeshe');

                // 检查连接
                if (!$link) {
                    exit('数据库连接失败！');
                }


                // 获取URL参数中的student_id
                $student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';


                // 分页参数
                $records_per_page = 10; // 每页显示的记录数
                $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // 当前页码

                // 初始化搜索条件
                $sel = isset($_POST['sel']) ? $_POST['sel'] : '';
                $additional_conditions = $sel ? " AND (name LIKE '%$sel%' OR title LIKE '%$sel%' OR file_name LIKE '%$sel%' OR submit_time LIKE '%$sel%' OR remarks LIKE '%$sel%')" : "";
                $search_condition = "WHERE student_id = '$student_id'$additional_conditions";
                // 计算总记录数
                $total_records = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*) FROM submissions $search_condition"))[0];

                // 计算总页数
                $total_pages = ceil($total_records / $records_per_page);

                // 计算 OFFSET
                $offset = ($current_page - 1) * $records_per_page;

                // 获取当前页的数据
                $res = mysqli_query($link, "SELECT * FROM submissions $search_condition ORDER BY student_id ASC LIMIT $records_per_page OFFSET $offset");

                while ($row = mysqli_fetch_array($res)) {
                    $address = '<a href="' . htmlspecialchars($row[4]) . '" target="_blank">' . htmlspecialchars($row[4]) . '</a>';
                    echo "<tr align='center'>";
                    echo "<td>$row[1]</td><td>$row[2]</td><td>$row[3]</td>";
                    echo "<td> $address</td>";
                    echo "<td>$row[5]</td>";
                    echo "<td>$row[6]</td>";
                    echo "</tr>";
                }

                // 显示分页导航
                echo '<div class="pagination">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $current_page) {
                        echo "<span>$i</span> ";
                    } else {
                        echo "<a href='?page=$i'>$i</a> ";
                    }
                }
                echo '</div>';

                // 关闭数据库连接
                mysqli_close($link);
                ?>
            </table>
        </form>
    </div>
</body>
</html>