<?php
// Đường dẫn file (Lưu ý: Bạn cần chắc chắn file nằm đúng thư mục này)
$filename = "../textfiles/Quiz.txt"; 
$questions = [];
$isSubmitted = false;
$score = 0;
$totalQuestions = 0;

// 1. ĐỌC VÀ XỬ LÝ FILE
if (file_exists($filename)) {
    $content = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    $current_question = [];
    foreach ($content as $line) {
        $line = trim($line);
        if (empty($line)) continue;

        if (strpos($line, "ANSWER:") === 0) {
            // Lấy chuỗi đáp án (VD: "A, C")
            $ansString = trim(substr($line, strpos($line, ":") + 1));
            // Chuyển thành mảng và xóa khoảng trắng thừa (VD: ['A', 'C'])
            $current_question['answer'] = array_map('trim', explode(',', $ansString));
            
            $questions[] = $current_question;
            $current_question = [];
        } 
        elseif (preg_match('/^[A-Z]\./', $line)) {
            $current_question['options'][] = $line;
        } 
        else {
            if (!isset($current_question['question'])) {
                $current_question['question'] = "";
            }
            $current_question['question'] .= $line . " ";
        }
    }
    $totalQuestions = count($questions);
}

// 2. XỬ LÝ KHI NGƯỜI DÙNG NỘP BÀI
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isSubmitted = true;
    foreach ($questions as $index => $q) {
        // Lấy đáp án người dùng gửi lên (nếu không chọn thì là mảng rỗng)
        $userAnswers = isset($_POST['question_' . $index]) ? $_POST['question_' . $index] : [];
        
        // Lấy đáp án đúng từ file
        $correctAnswers = $q['answer'];

        // So sánh: 
        // 1. Số lượng phải bằng nhau
        // 2. Các phần tử giống nhau (dùng array_diff để kiểm tra sự khác biệt)
        if (count($userAnswers) == count($correctAnswers) && empty(array_diff($userAnswers, $correctAnswers))) {
            $score++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 2: Trắc nghiệm Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS tô màu đáp án sau khi nộp */
        .correct-answer { background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .wrong-answer { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
    </style>
</head>
<body>
<div class="container mt-5 mb-5" style="max-width: 800px;">
    <h2 class="text-center mb-4 text-primary">BÀI THI TRẮC NGHIỆM</h2>
    
    <?php if ($isSubmitted): ?>
        <div class="alert alert-success text-center fs-4">
            Kết quả: <strong><?= $score ?> / <?= $totalQuestions ?></strong> câu đúng
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <?php foreach ($questions as $index => $q): ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-info text-white">
                    <strong>Câu <?= $index + 1 ?>:</strong> 
                    <?= isset($q['question']) ? htmlspecialchars($q['question']) : 'Lỗi câu hỏi' ?>
                </div>
                
                <div class="card-body">
                    <?php if (isset($q['options'])): ?>
                        <?php foreach ($q['options'] as $option): ?>
                            <?php 
                                $optionKey = substr($option, 0, 1); // Lấy A, B, C...
                                
                                // Kiểm tra trạng thái input để hiển thị lại sau khi nộp
                                $isChecked = false;
                                if ($isSubmitted && isset($_POST['question_' . $index])) {
                                    if (in_array($optionKey, $_POST['question_' . $index])) {
                                        $isChecked = true;
                                    }
                                }

                                // Xử lý tô màu đáp án sau khi nộp
                                $classLabel = "";
                                if ($isSubmitted) {
                                    // Nếu là đáp án đúng -> Tô xanh
                                    if (in_array($optionKey, $q['answer'])) {
                                        $classLabel = "text-success fw-bold"; 
                                    }
                                    // Nếu người dùng chọn sai -> Tô đỏ dòng đó
                                    if ($isChecked && !in_array($optionKey, $q['answer'])) {
                                        $classLabel = "text-danger text-decoration-line-through";
                                    }
                                }
                            ?>
                            
                            <div class="form-check mb-2">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="question_<?= $index ?>[]" 
                                       value="<?= $optionKey ?>" 
                                       id="q<?= $index ?>_<?= $optionKey ?>"
                                       <?= $isChecked ? 'checked' : '' ?> 
                                       <?= $isSubmitted ? 'disabled' : '' ?> > 
                                
                                <label class="form-check-label <?= $classLabel ?>" for="q<?= $index ?>_<?= $optionKey ?>">
                                    <?= htmlspecialchars($option) ?>
                                    
                                    <?php if ($isSubmitted): ?>
                                        <?php if (in_array($optionKey, $q['answer'])): ?>
                                            <span class="badge bg-success ms-2">Đúng</span>
                                        <?php elseif ($isChecked): ?>
                                            <span class="badge bg-danger ms-2">Sai</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (!$isSubmitted): ?>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">Nộp bài</button>
            </div>
        <?php else: ?>
            <div class="d-grid gap-2">
                <a href="bai2.php" class="btn btn-warning btn-lg">Làm lại bài thi</a>
            </div>
        <?php endif; ?>
    </form>
</div>
</body>
</html>