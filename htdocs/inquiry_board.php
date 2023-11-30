<?php
    session_start();
    $s_id = isset($_SESSION["permission"])? $_SESSION["permission"]:"";
    $s_name = isset($_SESSION["email"])? $_SESSION["email"]:"";
    // echo "Session ID : ".$s_id." / Name : ".$s_name;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>문의 게시판</title>
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
                location.replace('logout.php');
            } else {
                // 사용자가 취소를 선택한 경우
                alert("로그아웃이 취소되었습니다.");
            }
        }
    </script>
</head>
<body>
    

    <!--<div class="quiz-container">
            <div class="board-title">
                <a href="./welcome.php" class="category-link">퀴즈 게시판</a>
                <?php if($s_id){ /*로그인 안했다면 안보여줌 */?> 
                    <a href="./purchase.php" class="category-link" >포인트 교환</a>
                    <div style="color:green;">문의 게시판</div>
                <?php } ?>
            </div>
        <?php if(!$s_id){/* 로그인 전  */ ?>
    <p>
        <div class="quiz-card" >
        <div class="quiz-header">
        <a href="./login.php">로그인</a>
        <a href="./join.php">회원가입</a>
        </div>
        </div>
    </p>-->
    <?php #} else{ ?>

    <div class="quiz-container"> <!-- 메뉴바 이전에 미리 생성 -->
        <?php include("./menu_bar.php");?>
        <!--<div class="board-title"></div>-->
            

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



            // 퀴즈 게시판 출력
            if ($resultInquiry->num_rows > 0) {
                while($row = $resultInquiry->fetch_assoc()) {
                    echo '<div class="quiz-card">';
                    echo '<div class="quiz-header"><a href="./read_inquiry.php?inquiry_id=' . $row["inquiry_id"] . '">' . $row["inquiry_content"] . '</a></div>';
                    echo '<div class="quiz-meta">작성자 ID: ' . $row["user_id"] .  ' | 작성일: ' . $row["created_at"] . '</div>';
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
            echo '<button type="submit" onclick="location.href=\'write_inquiry.php\'" class="write-button">글쓰기</button>';
        }
        ?>
        
    </div>

</body>
</html>
