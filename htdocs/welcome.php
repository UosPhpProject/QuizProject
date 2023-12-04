<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>퀴즈 게시판</title>
    <style>
        <?PHP include( "./quiz_style.inc" );?>
        <?PHP include( "./common_style.inc" );?>
    </style>
    <script>
        function confirmLogout() {
            var confirmLogout = confirm("정말 로그아웃 하시겠습니까?");

            if (confirmLogout) {
                // 사용자가 확인을 선택한 경우
                alert("로그아웃 되었습니다.");
                location.replace('./logout.php');
            } else {
                // 사용자가 취소를 선택한 경우
                alert("로그아웃이 취소되었습니다.");
            }
        }
    </script>
</head>
<body>
    <div class="quiz-container"> <!-- 메뉴바 이전에 미리 생성 -->
        <?php include("./menu_bar.php");?>
            
        <?php if(!$s_id){/* 로그인 전  */ ?>
    <p>
        <div class="quiz-card" >
        <div class="quiz-header">
        <a href="./login.php">로그인</a>
        <a href="./join.php">회원가입</a>
        </div>
        </div>
    </p>
    <?php } else{ ?>
    <?php   
            // 데이터베이스 연결 설정
            include "./dbcon.php";

            // 연결 확인
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // 퀴즈 데이터 가져오기
            $sql = "SELECT * FROM quiz ORDER BY created_at DESC";
            $result = $conn->query($sql);


            // 퀴즈 게시판 출력
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $id=$row["user_id"];
                    $sql="SELECT * FROM user WHERE user_id=$id";
                    $result1=$conn->query($sql);
                    $name=mysqli_fetch_array($result1);
                    echo '<div class="quiz-card">';
                    echo '<div class="quiz-header"><a href="./read.php?quiz_id=' . $row["quiz_id"] . '">' . $row["quiz_content"] . '</a></div>';
                    echo '<div class="quiz-meta">작성자: ' . $name["nickname"] . ' | 조회수: ' . $row["views"] . ' | 배점: ' . $row["points"] . ' | 작성일: ' . $row["created_at"] . '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            } else {
                echo "게시글이 없습니다.";
            }
            
            $conn->close();
            echo '<button type="submit" onclick="confirmLogout()">로그아웃</button>';
            if ($s_id==1){
                echo '<button type="submit" onclick="location.href=\'write_quiz.php\'" class="write-button">글쓰기</button>';
            }
        }
        ?>
        
    </div>

</body>
</html>
