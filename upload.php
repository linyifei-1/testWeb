<?php
// 数据库连接信息
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "webkeshe";

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $title = $_POST['title'];
    $file = $_FILES['file'];
    $remarks = $_POST['remarks'];

    // 检查文件上传错误
    if ($file['error'] === UPLOAD_ERR_OK) {
       // 设置文件存储路径
       $target_dir = "uploads/";
       // 获取文件的扩展名
       $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
       // 生成新的文件名，包含时间戳
       $new_file_name = basename($file['name']) . '_' . time() . '.' . $file_extension;
       $target_file = $target_dir . $new_file_name;

        // 确保上传目录存在
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // 移动上传的文件
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // 检查是否已存在该学号的记录
            $stmt = $conn->prepare("SELECT file FROM user WHERE id = ?");
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if ($row && !empty($row['file'])) {
                 // 插入提交记录到提交记录数据库
                $insert_stmt_log = $conn->prepare("INSERT INTO submissions (student_id, name, title, file_name, remarks) VALUES (?, ?, ?, ?, ?)");
                $insert_stmt_log->bind_param("sssss", $student_id, $name, $title, $new_file_name, $remarks);
                $insert_stmt_log->execute();
                $insert_stmt_log->close();
                // 更新记录
                $update_stmt = $conn->prepare("UPDATE user SET  title = ?, file = ?, 状态 = '未审核', remark = ? WHERE id = ?");
                $update_stmt->bind_param("ssss",  $title, $target_file,  $remarks, $student_id);
                if ($update_stmt->execute()) {
                    
                    echo "<script>alert('论文信息更新成功！');window.location.href =  'upload.html';</script>";
                } else {
                    echo "更新失败: " . $update_stmt->error;
                    echo "<script>alert('更新失败: " . $update_stmt->error . "'); window.location.href = 'upload.html';</script>";
                }
                $update_stmt->close();
            } else {
                // 插入提交记录到提交记录数据库
                $insert_stmt_log = $conn->prepare("INSERT INTO submissions (student_id, name, title, file_name, remarks) VALUES (?, ?, ?, ?, ?)");
                $insert_stmt_log->bind_param("sssss", $student_id, $name, $title, $new_file_name, $remarks);
                $insert_stmt_log->execute();
                $insert_stmt_log->close();
                // 插入新记录
                $insert_stmt = $conn->prepare("INSERT INTO user (id, sname, title, file, remark) VALUES (?, ?, ?, ?, ?)");
                $insert_stmt->bind_param("sssss", $student_id, $name, $title, $target_file, $remarks);
                if ($insert_stmt->execute()) {
                    
                    echo "<script>alert('论文提交成功！');window.location.href =  'upload.html';</script>";
                } else {
                    
                    echo "<script>alert('提交失败: " . $insert_stmt->error . "'); window.location.href = 'upload.html';</script>";
                }
                $insert_stmt->close();
            }
        } else {
            echo "文件移动失败。";
        }
    } else {
        echo "文件上传失败: " . $file['error'];
    }
}

// 关闭数据库连接
$conn->close();
?>