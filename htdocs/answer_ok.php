<?php
/* 폼 값 가져오기 */
$user_id = $_POST["user_id"];
$quiz_id = $_POST["quiz_id"];
$answer = $_POST["answer"];
$points = $_POST["points"];

//echo "User ID: $user_email, Quiz ID: $quiz_id, Answer: $answer, Points: $points";

/* DB 접속 */
include "./dbcon.php";


$sql2 = "select answer_content, count from answer where user_id='$user_id' and quiz_id='$quiz_id';";
$result_sql2 = mysqli_query($conn, $sql2);
$num = mysqli_num_rows($result_sql2);
if($num) {
    // 이미 존재하는 경우
    $sql3 = "UPDATE answer SET answer_content = '$answer', count = count + 1 WHERE quiz_id='$quiz_id' and user_id='$user_id';";
} else {
    // 존재하지 않는 경우
    $sql3 = "INSERT INTO answer (quiz_id, user_id, answer_content, count, created_at) VALUES ('$quiz_id', '$user_id', '$answer', 1, now());";
}
$result_sql3 = mysqli_query($conn, $sql3);

$result_sql2 = mysqli_query($conn, $sql2);

list($answer_content, $count) = mysqli_fetch_array($result_sql2);


$sql4 = "select correct_answer from quiz where quiz_id='$quiz_id';";
$result_sql4 = mysqli_query($conn, $sql4);
list($c_answer) = mysqli_fetch_array($result_sql4);


if ($c_answer == $answer_content) {
    // 유저 포인트 업
    $sql5 = "update user set points = points + $points where user_id='$user_id';";
    $result_sql5 = mysqli_query($conn, $sql5);
    
    // count 3로 change
    $sql6 = "update answer set count = 3 where quiz_id='$quiz_id' and user_id='$user_id';";
    $result_sql6 = mysqli_query($conn, $sql6);
    mysqli_close( $conn );
    echo "
    <script type=\"text/javascript\">
    alert(\"정답입니다.\");
        location.href = \"./read.php?quiz_id=$quiz_id\";
    </script>
";
}

// read.php로 돌아가
echo "
    <script type=\"text/javascript\">";
        if ($count == 3) {
            echo "alert(\"기회를 모두 소진했습니다. 정답이 공개됩니다.\");";
        } else {
            echo "alert(\"정답이 일치하지 않습니다.\");";
        }
        echo "location.href = \"./read.php?quiz_id=$quiz_id\";
    </script>
";
?>
