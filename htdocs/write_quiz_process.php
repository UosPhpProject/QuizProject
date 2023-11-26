<?php
session_start();

// 로그인 여부 확인
if (!isset($_SESSION["permission"])) {
    header("Location: login.php");
    exit();
}

// 폼에서 전송된 데이터 처리
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 데이터베이스 연결 설정
    include "./dbcon.php";

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $quizTitle = $_POST["quizTitle"];
    $quizAnswer = $_POST["correct_answer"];
    $userId = $_SESSION["permission"];

    // 데이터베이스에 퀴즈 등록
    $sql = "INSERT INTO quiz (quiz_content, correct_answer, user_id) VALUES ('$quizTitle', '$quizAnswer', '$userId')";
    $result = $conn->query($sql);

    // 연결 종료
    $conn->close();

    echo '<script>';
    if ($result) {
        // 등록이 성공했을 경우
        echo 'alert("퀴즈가 성공적으로 등록되었습니다.");';
        echo 'window.location.href = "welcome.php";'; // welcome.php로 이동
    } else {
        // 등록이 실패한 경우
        echo 'alert("퀴즈 등록에 실패했습니다.");';
    }
    echo '</script>';
}
?>
