<?php
include("./config.php");
include("./functions.php");

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$kind = isset($_GET['kind']) ? $con->real_escape_string($_GET['kind']) : null;
$key = isset($_GET['key']) ? $con->real_escape_string($_GET['key']) : null;

$where = '';
$paramsType = '';
$params = array();
if ($key) {
  $where = "WHERE $kind LIKE ?";
  $paramsType = 's';
  $params[] = "%$key%";
}

// 총 글의 수 검색
$query = "SELECT COUNT(*) AS total_rows FROM board $where";
$stmt = $con->prepare($query);
if ($where) {
  $stmt->bind_param($paramsType, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_rows = $row['total_rows'];

// 페이지네이션 계산
$total_pages = ceil($total_rows / $rows_page);
$start_row = $rows_page * ($page - 1);

// 데이터베이스에서 목록 추출
$query = "SELECT uid, gid, depth, name, subject, writedate, refnum 
          FROM board $where 
          ORDER BY gid DESC, depth ASC 
          LIMIT ?, ?";
$stmt = $con->prepare($query);
if ($where) {
  $paramsType .= 'ii';
  $params[] = $start_row;
  $params[] = $rows_page;
  $stmt->bind_param($paramsType, ...$params);
} else {
  $stmt->bind_param("ii", $start_row, $rows_page);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<html>

<head>
  <style>
    <?PHP include("./common_style.css"); ?>TD {
      padding: 3px;
    }

    .field_tr {
      background: #93BCEA;
    }

    .list_tr {
      background: #EAF4FD;
    }
  </style>

  </style>
  <title>게시판</title>
</head>

<body>
  <center>
    <table>
      <!-- 게시판 헤더 -->
      <tr class="field_tr" align="center">
        <td width="50">번호</td>
        <td width="360">제목</td>
        <td width="90">글쓴이</td>
        <td width="60">작성일</td>
        <td width="40">조회</td>
      </tr>

      <?php while ($row = $result->fetch_assoc()) : ?>
        <tr class="list_tr">
          <td align="center"><?php echo $row['uid']; ?></td>
          <td> <a href="<?= dest_url("./count_ref.php", $page, $row['uid']) ?>"><?php echo htmlspecialchars($row['subject']); ?></a></td>
          <td align="center"><?php echo htmlspecialchars($row['name']); ?></td>
          <td align="center"><?php echo $row['writedate']; ?></td>
          <td align="center"><?php echo $row['refnum']; ?></td>
        </tr>
      <?php endwhile; ?>
    </table>

    <!-- 페이지네이션 -->
    <table>
      <tr>
        <td>
          <?php if ($page > 1) : ?>
            <a href="list.php?page=<?php echo $page - 1; ?>">[이전]</a>
          <?php endif; ?>
          <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <a href="list.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
          <?php endfor; ?>
          <?php if ($page < $total_pages) : ?>
            <a href="list.php?page=<?php echo $page + 1; ?>">[다음]</a>
          <?php endif; ?>
        </td>
        <td width="100" align="right">
          <a href="<?= dest_url("./write.php", $page) ?>">글쓰기</a>
          <a href="./list.php">목록</a>
        </td>
      </tr>
    </table>
    <table>
      <form name="search_form" method="post" action="./list.php">
        <tr align="center">
          <td>
            <select name="kind">
              <option value="subject" <? if ($kind == "subject")
                                        echo (" selected"); ?>>제목</option>
              <option value="article" <? if ($kind == "article")
                                        echo (" selected"); ?>>내용</option>
              <option value="name" <? if ($kind == "name")
                                      echo ("selected"); ?>>이름</option>
            </select>
            <input type="text" name="key" value="<?= $key ?>" size="20">
            <input type="submit" value="검색">
          </td>
        </tr>
      </form>
    </table>
  </center>
</body>

</html>