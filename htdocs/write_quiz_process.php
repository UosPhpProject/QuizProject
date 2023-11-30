<?php
session_start();

// 사용자가 로그인되어 있는지 확인합니다.
if (!isset($_SESSION["permission"])) {
    header("Location: login.php");
    exit();
}

// 폼이 제출되었는지 확인합니다.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 데이터베이스 연결 설정을 포함합니다.
    include "./dbcon.php";

    // 세션에서 사용자 정보를 가져옵니다.
    $user_id = $_SESSION["user_id"];
    $nickname = $_SESSION["nickname"];

    // 폼에서 퀴즈 정보를 가져옵니다.
    $quiz_content = $_POST["quizTitle"];
    $correct_answer = $_POST["quizAnswer"];
    $views = 0; // 초기 조회수
    $points = 0; // 초기 점수, 원하는 기본값으로 설정하세요.
    $created_at = date("Y-m-d H:i:s"); // 현재 날짜와 시간

    // 입력값이 빈 값인지 확인합니다.
    if (empty($quiz_content) || empty($correct_answer)) {
        echo '<script>alert("퀴즈 제목과 정답을 모두 입력해주세요.");</script>';
        echo '<script>window.location.href = "write_quiz.php";</script>';
        exit();
    }

    // 퀴즈를 데이터베이스에 추가합니다.
    $sql = "INSERT INTO quiz (quiz_content, user_id, views, points, created_at, correct_answer, nickname) 
            VALUES ('$quiz_content', '$user_id', '$views', '$points', '$created_at', '$correct_answer', '$nickname')";

    if ($conn->query($sql) === TRUE) {
        // 퀴즈가 성공적으로 추가되었을 때
        echo '<script>alert("퀴즈가 성공적으로 등록되었습니다.");</script>';
        echo '<script>window.location.href = "welcome.php";</script>';
        exit();
    } else {
        // 퀴즈 추가 중 오류가 발생한 경우 오류 메시지를 출력합니다.
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // 데이터베이스 연결을 닫습니다.
    $conn->close();
}
?>
