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

    // 폼에서 문의 정보를 가져옵니다.
    //$inquiry_id = $_GET["inquiry_id"];
    $quiz_id = $_POST["quiz_id"];
    $inquiry_content = $_POST["inquiry_content"];
    $created_at = date("Y-m-d H:i:s"); // 현재 날짜와 시간


    // 문의를 데이터베이스에 추가합니다.
    $sql = "INSERT INTO inquiry (user_id, quiz_id, inquiry_content, created_at) 
            VALUES ('$user_id', '$quiz_id', '$inquiry_content', '$created_at')";

    if ($conn->query($sql) === TRUE) {
        // 문의가 성공적으로 추가되었을 때
        echo '<script>alert("문의가 성공적으로 등록되었습니다.");</script>';
        echo '<script>window.location.href = "welcome.php";</script>';
        exit();
    } else {
        // 문의 추가 중 오류가 발생한 경우 오류 메시지를 출력합니다.
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // 데이터베이스 연결을 닫습니다.
    $conn->close();
}
?>
