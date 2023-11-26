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
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .quiz-container {
            width: 70%;
            margin: auto;
        }

        .board-title {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .category-link {
            font-size: 1em;
            color: #555;
            text-decoration: none;
            margin-bottom: 10px;
            display: block;
        }

        .quiz-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .quiz-header {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .quiz-meta {
            color: #555;
            font-size: 0.8em;
            margin-bottom: 10px;
        }

        .button-container {
            overflow: hidden;
        }

        .logout-button {
            float: left;
        }

        .write-button {
            float: right;
        }

        .button-container div {
            width: 50%;
            box-sizing: border-box;
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
    </script>
</head>
<body>
    
    <div class="quiz-container">
        <div class="board-title">
            <div>퀴즈 게시판</div>
            <a href="./inquiry_board.php" class="category-link">문의 게시판</a>
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
                    echo '<div class="quiz-card">';
                    echo '<div class="quiz-header"><a href="./read.php?quiz_id=' . $row["quiz_id"] . '">' . $row["quiz_content"] . '</a></div>';
                    echo '<div class="quiz-meta">작성자 ID: ' . $row["user_id"] . ' | 조회수: ' . $row["views"] . ' | 배점: ' . $row["points"] . ' | 작성일: ' . $row["created_at"] . '</div>';
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
