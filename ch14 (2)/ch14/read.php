<html>
<head>
  <link rel="stylesheet" type="text/css" href="./common_style.css">
  <style>  
    .info_table {
      background-color: #CFE1FC;
      border: solid 1pt;
    }
    .article_table {
      background-color: #EFF8FE;
      border: solid 1pt;
    }
  </style>
</head>
<body>
<center>

<?php
include("./config.php");
include("./functions.php");

$uid = isset($_GET['uid']) ? (int)$_GET['uid'] : 0;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// 데이터베이스에서 글의 정보 검색
$query = "SELECT gid, name, email, homepage, subject, article, writedate, refnum 
          FROM board WHERE uid = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$subject = htmlspecialchars($row['subject']);
$article = $tag_enable ? $row['article'] : htmlspecialchars($row['article']);
$article = nl2br($article);
$email = $row['email'];
$name = $row['name'];
$homepage = $row['homepage'];
$refnum = $row['refnum'];
?>

    <table class="info_table">
      <tr>
        <td width="590" colspan="2"><b><?=$subject?></b></td>
      </tr>
      <tr>
        <td width="510">글쓴이&nbsp;:&nbsp;

      <?PHP
        if( $email )
          echo( "<a href=\"mailto:$email\">$name</a>" );
        else
          echo $name;

        if( $homepage )
          echo("&nbsp;&nbsp;&nbsp;<a href=\"http://$homepage\">
            [homepage]</a>" );
      ?>

        </td>
        <td width="90">조회:<?=$refnum?></td>
      </tr>
    </table>

    <table class="articel_table">
      <tr>
        <td><?=$article?></td>
      </tr>
    </table>

    <table>
      <tr align="right">
        <td><a href="<?=dest_url( "./edit.php", $page, $uid )?>">수정</a>
        <a href="<?=dest_url( "./reply.php", $page, $uid )?>">답변</a>
        <a href="<?=dest_url( "./delete.php", $page, $uid )?>">삭제</a>
        <a href="<?=dest_url( "./list.php" , $page )?>">목록</a></td>
      </tr>
    </table>
    </center>
  </body>
</html>
