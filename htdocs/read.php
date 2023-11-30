<html>
  <head>
    <title>글 상세페이지</title>

    <style>

      <?PHP include( "./quiz_style.inc" );?>
      <?PHP include( "./common_style.inc" );?>

      .info_table
      {
        min-height : 80px;
        background-color : #999;
        border : solid 1pt;
      }

      .articel_table
      {
        min-height : 150px;
        background-color : #EFF8FE;
        border : solid 1pt;
      }

    </style>
    
  </head>

  <body>
    <div class="quiz-container">
        <div class="board-title">
            <div>퀴즈 게시판</div>
            <a href="./inquiry_board.php" class="category-link">문의 게시판</a>
        </div>

      <?PHP
        include( "./config.cfg" );
        include( "./functions.inc" );

        // 세션에서 접속자 정보 가져오기
        session_start();
        //var_dump($_SESSION);
        $cur_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;


        // quiz_id 값 읽어오기
        $quiz_id = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null;

        // quiz_id 값이 없으면 오류 처리 또는 기본값 설정
        if (!$quiz_id) {
            die("quiz_id를 제공해주세요.");
        }
        
        $con = mysqli_connect( "localhost", "phpadmin", "phpadmin" , "project" );
        if (mysqli_connect_errno()) {
          printf("%s \n", mysqli_connect_error());
          exit;
        }
        
        $nickname = $_SESSION["nickname"];
        echo $nickname;

        #mysqli_select_db( $con, "project" );
        
        #------------- 데이터베이스에서 글의 정보 검색 -------------#
        #$answer_id = 1; #임시
        
        // $query = "select answer_id, quiz_id, user_id, answer_content, count, created_at 
        //   from answer where answer_id=$answer_id";
        // $result = mysqli_query( $con, $query ) or die ( mysqli_error($con) );
        // list( $answer_id, $quiz_id, $user_id, $answer_content, $count, $created_at ) 
        //   = mysqli_fetch_array( $result );


        $query_quiz = "SELECT quiz_content, views, points, user_id, correct_answer, created_at FROM quiz WHERE quiz_id=$quiz_id";
        $result_quiz = mysqli_query($con, $query_quiz);
        list($quiz_content, $views, $points, $user_id, $correct_answer, $created_at) = mysqli_fetch_array($result_quiz);

        $query_user = "select nickname from user where user_id=$user_id";
        # 작성자 user와 접속자 user를 구분할 것
        $result_user = mysqli_query($con, $query_user);
        list($nickname) = mysqli_fetch_array($result_user);

        $query_answer = "select count from answer where user_id='$cur_user_id' and quiz_id='$quiz_id';";
        $result_answer = mysqli_query($con, $query_answer);
        list($count) = mysqli_fetch_array($result_answer);

       

        mysqli_close( $con );
        
        #------------------ html 특수 문자 처리-----------------#
        $quiz_content = htmlspecialchars( $quiz_content );
        
        if ( !$tag_enable )
          $correct_answer = htmlspecialchars( $correct_answer );
        $correct_answer = nl2br( $correct_answer );
        
      ?>

      <table class="info_table">
        <tr>
          <td colspan="2">
            <div class="quiz-title"><?=$quiz_content?></div>
          </td>
        </tr>
        <tr>
          <td><div class="quiz-info">글쓴이 : <?=$nickname?></div></td>
          <td><div class="quiz-info">배점 : <?=$points?></div></td>
          <td><div class="quiz-info">조회 : <?=$views?></div></td>
          <td><div class="quiz-info">작성일 : <?=$created_at?></div></td>
        </tr>
      </table>

      
      <?php if ($count == 3) {
        echo '<table class="articel_table">';
        echo '<tr>';
        echo '<td colspan="2"><div class="answer">' . $correct_answer . '</div></td>';
        echo '</tr>';
        echo '</table>';
      } else {
        echo '<table class="articel_table">';
        echo '<tr>';
        echo '<td>';
        echo '<div class="answer">답을 입력해주세요</div>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo '<div class="answer">';
        echo '<form name="answer_form" action="answer_ok.php" method="post">';
        echo '<input type="hidden" name="user_id" value="' . $cur_user_id . '">';
        echo '<input type="hidden" name="quiz_id" value="' . $quiz_id . '">';
        echo '<input type="hidden" name="points" value="' . $points . '">';
        echo '<input type="text" name="answer">';
        echo '<button type="submit">제출</button>';
        echo '</form>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
      } ?>
      

      <br>

      <table>
        <tr align="left">
          <a href='./write_quiz.php?quiz_id=' . $quiz_id> 문의하기</a>;
        </tr>
        <tr align="right">
          <td>
            <?php
              if($cur_user_id == $user_id) {
                echo '<a href=';
                #작동확인
                dest_url( "./delete.php?quiz_id=$quiz_id", $quiz_id );
                echo '>삭제</a>';
              } ?>
            
          
          
          
          <a href="./welcome.php">목록</a></td>
        </tr>
      </table>
    </center>
  </body>
</html>
