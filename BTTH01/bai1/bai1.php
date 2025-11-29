<?php
// Dữ liệu mô phỏng (trong thực tế sẽ lấy từ DB ở bài 4)
$flowers = [
    [
        'name' => 'Hoa Hải Đường',
        'description' => 'Mang ý nghĩa phú quý, anh em hòa hợp, cuộc sống vui vầy.',
        'image' => '../images/haiduong.jpg'
    ],
    [
        'name' => 'Hoa Mai',
        'description' => 'Biểu tượng của mùa xuân miền Nam, mang lại may mắn.',
        'image' => '../images/mai.jpg'
    ],
    [
        'name' => 'Hoa Tường Vy',
        'description' => 'Loài hoa mong manh, mang ý nghĩa của sự bảo vệ, che chở.',
        'image' => '../images/tuongvy.jpg'
    ],
    [
        'name' => 'Hoa Đỗ Quyên',
        'description' => 'Loài hoa rực rỡ báo hiệu mùa xuân về.',
        'image' => '../images/doquyen.jpg'
    ]
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 1: Danh sách các loài hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4 text-primary">1. Dành cho Khách (Client)</h3>
    <div class="row">
        <?php foreach ($flowers as $flower): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="<?= $flower['image'] ?>" class="card-img-top" alt="<?= $flower['name'] ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?= $flower['name'] ?></h5>
                    <p class="card-text"><?= $flower['description'] ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <hr>

    <h3 class="mb-4 text-danger">2. Dành cho Quản trị (Admin)</h3>
    <a href="#" class="btn btn-success mb-2">Thêm mới</a>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Tên hoa</th>
                <th>Mô tả</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($flowers as $flower): ?>
            <tr>
                <td><?= $flower['name'] ?></td>
                <td><?= $flower['description'] ?></td>
                <td><img src="<?= $flower['image'] ?>" width="100"></td>
                <td>
                    <button class="btn btn-primary btn-sm">Sửa</button>
                    <button class="btn btn-danger btn-sm">Xóa</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>