<html>
    <head>

    <style>

<?PHP include( "./quiz_style.inc" );?>
<?PHP include( "./common_style.inc" );?>
    </style>
    </head>

<body>
<div class="quiz_contanier">
<div class="quiz-card">
<?php

    include "./dbcon.php";
    
    $sql = "select * from product where product_id=2";
// echo $sql;

/* 쿼리 전송(연결 객체) */
    $result = mysqli_query($conn, $sql);

/* DB에서 결과값 가져오기 */
// mysqli_fetch_row // 필드 순서
// mysqli_fetch_array // 필드명
// mysqli_num_rows // 결과행의 개수
    $array = mysqli_fetch_array($result);
    $image=$array['image'];
    echo "<img src='img/$image' width=100/>";
    $num = mysqli_num_rows($result);
    print_r($array)

?>
</div>
</div>
</body>
</html>
