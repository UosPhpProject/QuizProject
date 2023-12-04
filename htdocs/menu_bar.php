<?php
    session_start();
    $s_id = isset($_SESSION["permission"])? $_SESSION["permission"]:"";
    $cur_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "";
    $s_name = isset($_SESSION["email"])? $_SESSION["email"]:"";
    // echo "Session ID : ".$s_id." / Name : ".$s_name;
?>
            
<div class="board-title">
    <a href="./welcome.php" class="category-link" style="color:green;">퀴즈 게시판</a>
    <?php if($s_id){ /*로그인 안했다면 안보여줌 */?> 
        <a href="./purchase.php" class="category-link" >포인트 교환</a>
        <a href="./inquiry_board.php" class="category-link">문의 게시판</a>
    <?php } ?>
</div>