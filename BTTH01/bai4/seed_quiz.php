<?php
require './db.php';
$filename = "../textfiles/Quiz.txt"; 

if (!file_exists($filename)) {
    die("Lỗi: Không tìm thấy file $filename");
}

$content = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$current_q = [];

try {
    // Xóa dữ liệu cũ để tránh trùng lặp
    $conn->exec("DELETE FROM options");
    $conn->exec("DELETE FROM questions");
    $conn->exec("ALTER TABLE questions AUTO_INCREMENT = 1");
    $conn->exec("ALTER TABLE options AUTO_INCREMENT = 1");

    foreach ($content as $line) {
        $line = trim($line);
        if (empty($line)) continue;

        if (strpos($line, "ANSWER:") === 0) {
            // --- FIX LỖI: Kiểm tra nếu chưa có câu hỏi thì bỏ qua ---
            if (!isset($current_q['text']) || empty($current_q['text'])) {
                $current_q = [];
                continue;
            }

            $ans = trim(substr($line, 7)); // Cắt bỏ chữ "ANSWER:"
            $correctOpts = array_map('trim', explode(',', $ans));
            
            // Insert câu hỏi
            $stmt = $conn->prepare("INSERT INTO questions (question_text) VALUES (?)");
            $stmt->execute([$current_q['text']]);
            $q_id = $conn->lastInsertId();

            // Insert đáp án
            if (isset($current_q['opts'])) {
                foreach ($current_q['opts'] as $opt) {
                    $key = substr($opt, 0, 1); // Lấy A, B, C...
                    $is_correct = in_array($key, $correctOpts) ? 1 : 0;
                    $stmtOpt = $conn->prepare("INSERT INTO options (question_id, option_text, is_correct) VALUES (?, ?, ?)");
                    $stmtOpt->execute([$q_id, $opt, $is_correct]);
                }
            }
            $current_q = []; // Reset
        } elseif (preg_match('/^[A-Z]\./', $line)) {
            $current_q['opts'][] = $line;
        } else {
            // Nối chuỗi câu hỏi (xử lý câu hỏi nhiều dòng)
            if (!isset($current_q['text'])) $current_q['text'] = "";
            $current_q['text'] .= $line . " ";
        }
    }
    echo "<h1>Thành công! Đã nạp dữ liệu Quiz vào Database.</h1>";
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>