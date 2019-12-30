<?php require_once 'pages/header.php' ?>
<div class="body"><!-- start body-->
    <?php require_once 'pages/sidebar.php' ?>
    <?php
    $row = selectComment($_GET['comment_id']);
    $replyComment = sendReplyComment($row['comment_id'], $row['comment_post_id']);
    if ($replyComment) {
        header('location:Comments.php');
    }
    ?>
    <div class="content"> <!--- start Content --->
        <p class="alert alert-info">ارسال پاسخ</p>
        <br>
        <form action="" method="post">
            <input type="hidden" value="<?php echo $row['comment_id'] ?>" class="textbox" name="comment_id">
            <input disabled type="text" value="<?php echo $row['comment_author'] ?>" class="textbox">
            <input disabled type="text" value="<?php echo showPostForComment($row['comment_post_id']) ?>"
                   class="textbox">
            <input disabled type="text" value="<?php echo $row['comment_email'] ?>" class="textbox">
            <textarea disabled class="textbox"
                      style="height: 150px;padding: 12px;"><?php echo $row['comment_body'] ?></textarea>
            <textarea name="comment_body" class="textbox" style="height: 170px;padding: 12px;"></textarea>
            <br>
            <input type="submit" class="btn btn-success" name="sendReplyComment" value="ارسال پاسخ">
            <input type="reset" class="btn btn-error" value="انصراف">
        </form>
    </div><!--- end Content --->
    <div class="clear"></div>
</div><!-- end body-->

<?php require_once 'pages/footer.php' ?>

