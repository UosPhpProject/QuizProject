<html>
<body>
<?php
$conn = mysqli_connect ('localhost', 'phpadmin1', 'zaza4490', 'goods');
if (mysqli_connect_errno()) {
printf("%s \n", mysqli_connect_error());
exit;
}
$query = "INSERT INTO fruit VALUES ('" .
$_POST['name'] . "', " . $_POST['price'] . ", '" .
$_POST['color']. "', '" . $_POST['country'] . "')";
$result = mysqli_query ($conn, $query);
if ($result)
print "입력되었습니다.<br>";
else
print "입력되지 않았습니다.<br>";
?>
</body>
</html>