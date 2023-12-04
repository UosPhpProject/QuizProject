<?PHP
        // 세션에서 접속자 정보 가져오기
    session_start();
        //var_dump($_SESSION);
    $cur_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;


        // quiz_id 값 읽어오기
    $product_price = isset($_GET['price']) ? $_GET['price'] : null;

        // quiz_id 값이 없으면 오류 처리 또는 기본값 설정
        if (!$product_price) {
            die("가격를 제공해주세요.");
        }
        include "./dbcon.php";

        if (mysqli_connect_errno()) {
          printf("%s \n", mysqli_connect_error());
          exit;
        }
    print $cur_user_id;
    $sql = "SELECT points FROM user where user_id=$cur_user_id";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_fetch_row($result);
    $user_money=$num[0];

    if($user_money<$product_price)
    {
        echo "
        <script type=\"text/javascript\">
            alert(\"포인트가 모자랍니다.\");
            history.back();
        </script>
    ";
    }
    else
    {
        $after_money=$user_money-$product_price;
        echo $after_money;
        $sql="UPDATE user SET points=$after_money where user_id=$cur_user_id";
        $result = mysqli_query($conn, $sql);
        echo "
            <script type=\"text/javascript\">
                alert(\"구매완료\");
                location.href = \"../purchase.php\";
            </script>
        ";
    }
?>

        