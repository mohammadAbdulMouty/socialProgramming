<?php

include 'connect.php';
include 'includes/functions/function.php';
$stmt = $con->prepare('SELECT * FROM `comments` WHERE postid =:postid ORDER BY date desc');
$stmt->bindParam(':postid',$_POST['postid'],PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();
echo '<div class="comment-with-out-textarea" data-simplebar>';
foreach($rows as $row){
    ?>

<div class="comment-element">
        <a href=""><img src="data/uploads/images/default.jpg"><h5><?php echo $row['name'] ?></h5></a>
        <p class="date-comment"><?php echo dateGo($row['date']) ?></p>
        <div class="comment-body">
            <p><?php echo $row['body'] ?></p>
        </div>
        <hr style="margin-top: 0;margin-bottom: 0;">
    </div><!--end div.comment-element -->
   
<?php
}
echo '</div>';
?>
 <textarea placeholder="add Comments...." class="new-comments-group"></textarea>
