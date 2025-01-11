<?php
// 下载脚本
if (isset($_GET['file'])) {
    $file = urldecode($_GET['file']);
    $filePath = "uploads/" . basename($file); // 假设文件存储在 uploads 目录下

    if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        echo "文件不存在";
    }
} else {
    echo "无效的请求";
}
?>