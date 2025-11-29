<?php
$filename = "../textfiles/65HTTT_Danh_sach_diem_danh.csv";
$data = [];

if (file_exists($filename)) {
    if (($handle = fopen($filename, "r")) !== FALSE) {
        // Đọc dòng đầu tiên làm tiêu đề (Header)
        $headers = fgetcsv($handle, 1000, ",");
        
        // Loại bỏ BOM (Byte Order Mark) nếu có trong file CSV (lỗi hiển thị ký tự lạ đầu tiên)
        if ($headers && isset($headers[0])) {
            $headers[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $headers[0]);
        }

        // Đọc các dòng dữ liệu tiếp theo
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // --- ĐOẠN SỬA LỖI ---
            // Chỉ thêm vào mảng nếu số cột của dòng bằng số cột của tiêu đề
            if (count($row) === count($headers)) {
                $data[] = array_combine($headers, $row);
            }
        }
        fclose($handle);
    }
} else {
    echo "<div class='alert alert-danger'>Không tìm thấy file CSV! Hãy kiểm tra lại thư mục 'files/'.</div>";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 3: Danh sách sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center text-primary mb-4">Danh sách sinh viên từ CSV</h3>
    
    <?php if (empty($data)): ?>
        <div class="alert alert-warning">Không có dữ liệu để hiển thị.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Username</th>
                    <th>Họ đệm</th>
                    <th>Tên</th>
                    <th>Lớp</th>
                    <th>Email</th>
                    <th>Khóa học</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['username'] ?? '') ?></td>
                    <td><?= htmlspecialchars($user['lastname'] ?? '') ?></td>
                    <td><?= htmlspecialchars($user['firstname'] ?? '') ?></td>
                    <td><?= htmlspecialchars($user['city'] ?? '') ?></td>
                    <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                    <td><?= htmlspecialchars($user['course1'] ?? '') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>