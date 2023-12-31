<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>문의 게시판</title>
    <style>
        <?PHP include( "./quiz_style.inc" );?>
        <?PHP include( "./common_style.inc" );?>
        
        .quiz-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #ccc;
        padding: 10px;
        }

        .delBtn {
            background-color: red;
        }
    </style>
    <script>
        function confirmLogout() {
            var confirmLogout = confirm("정말 로그아웃 하시겠습니까?");

            if (confirmLogout) {
                // 사용자가 확인을 선택한 경우
                alert("로그아웃 되었습니다.");
                location.replace('logout.php');
            } else {
                // 사용자가 취소를 선택한 경우
                alert("로그아웃이 취소되었습니다.");
            }
        }

        function deleteInquiry($quiz_id) {
            location.replace('delete.php?quiz_id=' + $quiz_id);
            alert("삭제되었습니다.");
        }
    </script>
</head>
<body>
    
    <div class="quiz-container"> <!-- 메뉴바 이전에 미리 생성 -->
        <?php include("./menu_bar.php");?>

    <?php   
            // 데이터베이스 연결 설정
            include "./dbcon.php";

            // 연결 확인
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // 문의 데이터 가져오기
            $sqlInquiry = "SELECT * FROM inquiry ORDER BY created_at DESC";
            $resultInquiry = $conn->query($sqlInquiry);

            // 문의 게시판 출력
            if ($resultInquiry->num_rows > 0) {
                while($row = $resultInquiry->fetch_assoc()) {
                    $quiz_id = $row["quiz_id"];
                    $sql1="SELECT quiz_content FROM quiz WHERE quiz_id=$quiz_id";
                    $result_quiz=$conn->query($sql1);
                    $result=mysqli_fetch_row($result_quiz);

                    echo '<div class="quiz-card">';
                    echo '<div>';
                    echo '<div class="quiz-header">' . $row["inquiry_content"] . '</a></div>';
                    echo '<div class="quiz-meta">퀴즈 내용 : '. $result[0]. ' |  작성자 ID: ' . $row["user_id"] .  ' | 문의 작성일: ' . $row["created_at"]. '</div>';
                    echo '</div>';
                    if($s_id == 99) {
                        echo '<div>';
                        echo '<button class="delBtn" type="submit" onclick="deleteInquiry(' . $quiz_id . ')">퀴즈삭제</button>';
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '</a>';
                }
            } else {
                echo "게시글이 없습니다.";
            }
            // $ses= $_SESSION['permission'];
            // if($ses=="0"){
            //     echo '<div class="quiz-card">';
            //     echo '<div class="quiz-header">'. "문의 게시판".'</div>';
            //     echo '</div>';
            // }
            // 연결 종료
            $conn->close();
            echo '<button type="submit" onclick="confirmLogout()">로그아웃</button>';
        
        ?>
        
    </div>

</body>
</html>
