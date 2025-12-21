<?php
require './db.php';
$questions = $conn->query("SELECT * FROM questions")->fetchAll(PDO::FETCH_ASSOC);
$isSubmitted = ($_SERVER['REQUEST_METHOD'] === 'POST');
?>

<!DOCTYPE html>
<html lang="vi">
<head><title>Thi trắc nghiệm</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-5 mb-5">
    <h2>Bài thi trắc nghiệm (Dữ liệu MySQL)</h2>
    <form method="POST">
        <?php 
        $score = 0;
        foreach ($questions as $i => $q): 
            $opts = $conn->prepare("SELECT * FROM options WHERE question_id=?");
            $opts->execute([$q['id']]);
            $options = $opts->fetchAll();
            
            // Xử lý chấm điểm
            if ($isSubmitted) {
                $userPick = $_POST["q_{$q['id']}"] ?? [];
                $correctIds = array_column(array_filter($options, fn($o) => $o['is_correct']), 'id');
                if ($userPick == $correctIds) $score++;
            }
        ?>
        <div class="card mb-3">
            <div class="card-header">Câu <?= $i+1 ?>: <?= htmlspecialchars($q['question_text']) ?></div>
            <div class="card-body">
                <?php foreach ($options as $opt): 
                    $checked = ($isSubmitted && in_array($opt['id'], $_POST["q_{$q['id']}"] ?? [])) ? 'checked' : '';
                    $style = "";
                    if ($isSubmitted) {
                        if ($opt['is_correct']) $style = "text-success fw-bold";
                        elseif ($checked) $style = "text-danger text-decoration-line-through";
                    }
                ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="q_<?= $q['id'] ?>[]" value="<?= $opt['id'] ?>" <?= $checked ?>>
                    <label class="form-check-label <?= $style ?>"><?= htmlspecialchars($opt['option_text']) ?></label>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
        
        <?php if ($isSubmitted): ?>
            <div class="alert alert-info">Điểm của bạn: <?= $score ?>/<?= count($questions) ?></div>
            <a href="bai2_db.php" class="btn btn-warning">Làm lại</a>
        <?php else: ?>
            <button class="btn btn-primary">Nộp bài</button>
        <?php endif; ?>
    </form>
</div></body></html>