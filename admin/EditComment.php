<?php require_once 'pages/header.php' ?>
<div class="body"><!-- start body-->
    <?php require_once 'pages/sidebar.php' ?>
    <?php
    $row = selectComment($_GET['edit']);

    if (isset($_GET['edit']) && isset($_POST['comment_id'])) {
        $updateComment = editComment($_POST['comment_id']);
        if ($updateComment) {
            $message = '<p class="alert alert-success">ویرایش با موفقیت انجام شد</p>';
            header("refresh:1, url = Comments.php");
        } else {
            $message = '<p class="alert alert-error">ویرایش با خطا مواجه شد</p>';
        }
    }
    ?>
    <div class="content"> <!--- start Content --->
        <p class="alert alert-info">ویرایش نظر</p>
        <br>
        <?php if (isset($message)) echo $message; ?>

        <form action="" method="post">
            <input type="hidden" value="<?php echo $row['comment_id'] ?>" class="textbox" name="comment_id">
            <input disabled type="text" value="<?php echo $row['comment_author'] ?>" class="textbox">
            <input disabled type="text" value="<?php echo showPostForComment($row['comment_post_id']) ?>"
                   class="textbox">
            <input disabled type="text" value="<?php echo $row['comment_email'] ?>" class="textbox">
            <textarea name="comment_body" class="textbox"
                      style="height: 150px;padding: 12px;"><?php echo $row['comment_body'] ?></textarea>
            <br>
            <input type="submit" class="btn btn-success" name="editComment" value="ارسال پاسخ">
            <input type="reset" class="btn btn-error" value="انصراف">
        </form>
    </div><!--- end Content --->
    <div class="clear"></div>
</div><!-- end body-->

<?php require_once 'pages/footer.php' ?>

