<html>
<head>
<style>


<?PHP include( "./common_style.inc" );?>

.info_table
{
  background-color : #CFE1FC;
  border : solid 1pt;
}

.articel_table
{
  background-color : #EFF8FE;
  border : solid 1pt;
}

</style>
<title>글 상세페이지</title>
</head>
<body>
<center>

<?PHP
  include( "./config.cfg" );
  include( "./functions.inc" );
  $con = mysqli_connect( "localhost", "phpadmin", "phpadmin" , "project" );
  if (mysqli_connect_errno()) {
    printf("%s \n", mysqli_connect_error());
    exit;
  }
  

  #mysqli_select_db( $con, "project" );
  
  #------------- 데이터베이스에서 글의 정보 검색 -------------#
  $answer_id = 1; #임시
  
  $query = "select answer_id, quiz_id, user_id, answer_content, count, created_at 
    from answer where answer_id=$answer_id";
  $result = mysqli_query( $con, $query ) or die ( mysqli_error($con) );
  list( $answer_id, $quiz_id, $user_id, $answer_content, $count, $created_at ) 
    = mysqli_fetch_array( $result );


    $query_quiz = "SELECT quiz_content FROM quiz WHERE quiz_id=$quiz_id";
    $result_quiz = mysqli_query($con, $query_quiz);
    list($quiz_content) = mysqli_fetch_array($result_quiz);

  $query_user = "select nickname from user where user_id=$user_id";
  # 작성자 user와 접속자 user를 구분할 것
  $result_user = mysqli_query($con, $query_user);
  list($nickname) = mysqli_fetch_array($result_user);

  
  mysqli_close( $con );
  
  #------------------ html 특수 문자 처리-----------------#
  $quiz_content = htmlspecialchars( $quiz_content );
  
  if ( !$tag_enable )
    $answer_content = htmlspecialchars( $answer_content );
  $answer_content = nl2br( $answer_content );
  
?>

<table class="info_table">
  <tr>
    <td width="590" colspan="2"><b><?=$quiz_content?></b></td>
  </tr>
  <tr>
    <td width="510">글쓴이&nbsp;:&nbsp; <?=$nickname?>
    



  <?PHP
  /*
  if( $email ) if user table has email echo it.
    echo ( "<a href=\"mailto:$email\">$name</a>" );
  else
    echo $name;
  
  if( $homepage )
    echo ( "&nbsp;&nbsp;&nbsp;<a href=\"http://$homepage\">[homepage]</a>" );
  */
  ?>





    </td>
    <td width="90">조회:<?=$count?></td>
  </tr>
</table>
<table class="articel_table">
  <tr>
    <td><?=$answer_content?></td>
  </tr>
</table>
<table>
  <tr align="right">
    <td><a href="<?=dest_url( "./delete.php", $page, $user_id )?>">삭제</a>
        <!--권한설정해주기-->
    <a href="<?=dest_url( "./list.php" , $page )?>">목록</a></td>
  </tr>
</table>
</center>
</body>
</html>
