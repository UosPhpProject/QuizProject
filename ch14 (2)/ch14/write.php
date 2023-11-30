<?php include("./functions.php"); ?>
<?php
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="./common_style.css">
  <style>
    .ques_head {
      background-color: #F9E79D;
      text-align: center;
    }
    .input_td {
      background-color: #FEFCE2;    
    }
  </style>
  <title>게시판</title>
</head>
<body>
  <form name="write_form" method="post" action="write_db.php">
    <center> 
    <table>
  <tr>
    <td class="ques_head">글쓴이</td>
    <td class="input_td">
      <input type="text" name="name" size="10" maxsize="10">
    </td>
  </tr>
  <tr>
    <td class="ques_head">e-mail</td>
    <td class="input_td">
      <input type="text" name="email" size="40" maxsize="50">
    </td>
  </tr>
  <tr>
    <td class="ques_head">홈페이지</td>
    <td class="input_td">
       <input type="text" name="homepage" size="40" maxsize="50">
    </td>
  </tr>
  <tr>
    <td class="ques_head">암호</td>
    <td class="input_td">
      <input type="password" name="passwd" size="10" maxsize="10">
    </td>
  </tr>
  <tr>
    <td class="ques_head">제목</td>
    <td class="input_td">
      <input type="text" name="subject" size="50" maxsize="255">
    </td>
  </tr>
  <tr>
    <td class="ques_head">내용</td>
    <td class="input_td">
      <textarea name="article" cols="60" rows="20"></textarea>
    </td>
  </tr>
</table>
      <table>
        <tr>
          <td width="100">&nbsp;</td>
          <td align="center"><input type="submit" value="입력"></td>
          <td width="100" align="right">
            <a href="<?=dest_url("./list.php", htmlspecialchars($page))?>">목록</a>
          </td>
        </tr>
      </table>
    </center>
  </form>
</body>
</html>
