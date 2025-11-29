<?php
require './db.php';
$msg = "";

if (isset($_POST['upload'])) {
    $file = $_FILES['file']['tmp_name'];
    if (($handle = fopen($file, "r")) !== FALSE) {
        fgetcsv($handle); // Bỏ dòng tiêu đề
        while (($row = fgetcsv($handle)) !== FALSE) {
            if (count($row) < 7) continue;
            try {
                $stmt = $conn->prepare("INSERT INTO students (username, password, lastname, firstname, class_name, email, course_code) VALUES (?,?,?,?,?,?,?)");
                $stmt->execute([$row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]]);
            } catch(PDOException $e) { /* Bỏ qua lỗi trùng lặp */ }
        }
        fclose($handle);
        $msg = "Import thành công!";
    }
}
$students = $conn->query("SELECT * FROM students LIMIT 10")->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head><title>Import CSV</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-5">
    <h2>Nhập sinh viên từ CSV</h2>
    <?php if ($msg) echo "<div class='alert alert-success'>$msg</div>"; ?>
    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <input type="file" name="file" class="form-control mb-2" required>
        <button name="upload" class="btn btn-primary">Upload & Import</button>
    </form>
    
    <h4>Danh sách sinh viên (Preview 10 bạn):</h4>
    <table class="table table-bordered">
        <tr><th>ID</th><th>Họ tên</th><th>Lớp</th><th>Email</th></tr>
        <?php foreach ($students as $s): ?>
        <tr><td><?= $s['id'] ?></td><td><?= $s['lastname'].' '.$s['firstname'] ?></td><td><?= $s['class_name'] ?></td><td><?= $s['email'] ?></td></tr>
        <?php endforeach; ?>
    </table>
</div></body></html>