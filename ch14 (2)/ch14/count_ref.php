<?php
include("./config.php");
include("./functions.php");

// $uid 값이 제대로 설정되었는지 확인
if (!isset($_GET['uid']) || empty($_GET['uid'])) {
    die("Error: 'uid' parameter is missing or empty");
}

$uid = mysqli_real_escape_string($con, $_GET['uid']);
$page = isset($_GET['page']) ? $_GET['page'] : 1; // 페이지 파라미터 처리

$query = "UPDATE board SET refnum = refnum + 1 WHERE uid = $uid";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Error updating record: " . mysqli_error($con));
}

mysqli_close($con);
forward(dest_url("./read.php", $page, $uid));
?>
