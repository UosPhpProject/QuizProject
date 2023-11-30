<?php
session_start();

// quiz_id 값 읽어오기
$quiz_id = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null;

// quiz_id 값이 없으면 오류 처리 또는 기본값 설정
if (!$quiz_id) {
    die("quiz_id를 제공해주세요.");
}

// 로그인 여부 확인
if (!isset($_SESSION["permission"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>문의 작성</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .quiz-container {
            width: 50%;
            margin: auto;
        }

        .quiz-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .quiz-header {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .quiz-form {
            margin-top: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .form-group button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="quiz-container">
    <div class="quiz-card">
        <div class="quiz-header">문의 작성</div>

        <form action="write_inquiry_process.php" method="post" class="quiz-form">
            <div class="form-group">
                <input type="hidden" name="quiz_id" value="<?=$quiz_id?>">
            </div>  
        
            <div class="form-group">
                <label for="inquiry_content">문의 내용:</label>
                <input type="text" name="inquiry_content" id="inquiry_content" required>
            </div>

            
            
            

            

            <div class="form-group">
                <button type="submit">등록</button>
                <button type="button" onclick="cancel()">취소</button>
            </div>
        </form>
    </div>
</div>

<script>
    function cancel() {
        alert("취소되었습니다.");
        location.href = "inquiry_board.php";
    }
</script>

</body>
</html>
