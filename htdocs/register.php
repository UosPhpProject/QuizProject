<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 데이터베이스 연결 설정
    include "./dbcon.php";
    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // POST 데이터 가져오기
    $nickname = $_POST["nickname"];
    $password =$_POST["password"];
    //$password = password_hash($_POST["password"]); // 비밀번호 암호화
    $email = $_POST["email"];
    $date =date("Y-m-d",strtotime ("+480 minutes")); //한국시간

    $check_duplicate_sql = "SELECT * FROM user WHERE email='$email'";
    $duplicate_result = $conn->query($check_duplicate_sql);

    if ($duplicate_result->num_rows > 0) {
        echo "
        <script type=\"text/javascript\">
            alert(\"동일한 아이디가 있습니다.\");
            history.back();
        </script>
        ";
    }
    // 데이터베이스에 사용자 추가
    else {
        $sql = "INSERT INTO user (permission,nickname, password, email,points, created_at) VALUES (1,'$nickname', '$password', '$email',0, '$date')";
        if ($conn->query($sql) === TRUE) {
            echo "회원가입이 완료되었습니다.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    // 연결 종료
    $conn->close();

    echo "
    <script type=\"text/javascript\">
        location.href = \"../welcome.php\";
    </script>
    ";
}
?>
