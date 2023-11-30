<?php 
    include("./menu_bar.php");
?>
<?php
    include("./dbcon.php");
    $quiz_id = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null;
    //삭제할 퀴즈 아이디 받아오기

    if($quiz_id==0)
    {
        echo "
        <script type=\"text/javascript\">
            alert(\"일치하는 아이디가 없습니다.\");
            location.href = \"../welcome.php\";
        </script>
        ";
    }

    $sql="DELETE FROM answer WHERE quiz_id=$quiz_id";
    $result=$conn->query($sql);

    $sql="DELETE FROM comment WHERE quiz_id=$quiz_id";
    $result=$conn->query($sql);

    
    $sql="DELETE FROM inquiry WHERE quiz_id=$quiz_id";
    $result=$conn->query($sql);

    $sql="DELETE FROM quiz where quiz_id=$quiz_id";
    $quiz = $conn->query($sql);


    mysqli_close($conn);

    /* 페이지 이동 */
    echo "
        <script type=\"text/javascript\">
            alert(\"삭제 되었습니다.\");
            location.href = \"./welcome.php\";
        </script>
    ";

?>