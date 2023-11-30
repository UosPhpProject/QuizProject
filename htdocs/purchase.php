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
    <title>퀴즈 게시판</title>
    <style>
        <?PHP include( "./quiz_style.inc" );?>
        <?PHP include( "./common_style.inc" );?>
    </style>
    <script>
        function confirmPurchase() {
            var confirmLogout = confirm("정말 구매 하시겠습니까?");

            if (confirmLogout) {
                // 사용자가 확인을 선택한 경우
                alert("구매 완료 되었습니다.");
                location.replace('./purchase.php');
            } else {
                // 사용자가 취소를 선택한 경우
                alert("구매가 취소되었습니다.");
            }
        }
    </script>
</head>
<body>
    <div class="quiz-container">
        <div class="board-title">
            <a herf="./welcome.php" class="category-link">퀴즈 게시판</a>
            <?php if($s_id){ ?>
                <a href="./purchase.php" class="category-link" >포인트 교환</a>
                <a href="./inquiry_board.php" class="category-link">문의 게시판</a>
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
    </p>
    <?php } else{ 
            // 데이터베이스 연결 설정
            include "./dbcon.php";

            // 연결 확인
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // 퀴즈 데이터 가져오기
            $sql = "SELECT * FROM product ORDER BY price DESC";
            $result = $conn->query($sql);

            // 퀴즈 게시판 출력
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="quiz-card">';
                    echo '<div class="quiz-header"><img src="img/'.$row["image"].'"width=100/>'. '</div>';
                    echo '<div class="quiz-meta">상품: ' . $row["product_name"] . ' | 가격: ' . $row["price"] . '</div>';
                    echo '<div class="quiz-header"><a href="./buy.php?price=' . $row["price"] . '">' ."구매".'</a></div>';
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
            echo '<button type="submit" onclick="location.href=\'write_quiz.php\'" class="write-button">글쓰기</button>';
        }
    ?>
        
    </div>
</body>
</html>

