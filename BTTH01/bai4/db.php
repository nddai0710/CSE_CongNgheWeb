<?php
// db.php
$host = '127.0.0.1';
$dbname = 'btth01_cse485'; // Tên DB phải trùng với trong phpMyAdmin
$username = 'root';
$password = ''; // XAMPP mặc định không pass

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}
?>