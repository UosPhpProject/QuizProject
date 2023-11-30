<?php 
include("config.php");
include("functions.php");

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$homepage = trim($_POST['homepage']);
$subject = trim($_POST['subject']);
$article = trim($_POST['article']);
$passwd = trim($_POST['passwd']);

if (!$name || !$subject || !$passwd || !$article) {
    error("입력값이 부족합니다.");
    exit;
}

if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    error("이메일을 잘못 입력하셨습니다.");
    exit;
}

if ($homepage && !filter_var($homepage, FILTER_VALIDATE_URL)) {
    error("홈페이지를 잘못 입력하셨습니다.");
    exit;
}

//$hashed_passwd = password_hash($passwd, PASSWORD_DEFAULT);
$hashed_passwd = $passwd;
$writedate = date("Y-m-d");

$query = "SELECT MAX(gid) AS gid FROM board";
$result = $con->query($query);
$row = $result->fetch_assoc();
$gid = $row['gid'] + 1;

$stmt = $con->prepare("INSERT INTO board (gid, name, email, homepage, passwd, subject, article, writedate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssssss", $gid, $name, $email, $homepage, $hashed_passwd, $subject, $article, $writedate);
$stmt->execute();

$con->close();
forward("./list.php");
?>
