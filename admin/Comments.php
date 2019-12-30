<?php require_once 'pages/header.php' ?>
<div class="body"><!-- start body-->
    <?php require_once 'pages/sidebar.php' ?>
    <?php
    if (isset($_GET['delete'])) {
        $deleteComment = deleteComment($_GET['delete']);
        if ($deleteComment) {
            header('location:Comments.php?success=ok');
        } else {
            header('location:Comments.php?error=ok');
        }
    }
    ?>
    <div class="content"> <!--- start Content --->
        <?php
        if (isset($_GET['success'])) {
            echo '<p class="alert alert-success">حذف با موفقیت انجام شد</p>';
        } elseif (isset($_GET['error'])) {
            echo '<p class="alert alert-error">حذف با  خطا مواجه شد</p>';
        }
        ?>
        <br>
        <table>
            <thead>
            <tr>
                <th>شناسه</th>
                <th>برای</th>
                <th>نام فرد ارسال کننده</th>
                <th>ایمیل</th>
                <th>متن نظر</th>
                <th>تاریخ</th>
                <th>وضعیت</th>
                <th width="10%">پاسخ دادن</th>
                <th width="13%">عملیات</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $selectAllComment = selectAllComment();
            if ($selectAllComment) {
                foreach ($selectAllComment as $index => $value) {
                    ?>
                    <tr>
                        <td><?php echo $index + 1 ?></td>
                        <td><?php echo showPostForComment($value['comment_post_id']); ?></td>
                        <td><?php echo $value['comment_author'] ?></td>
                        <td><?php echo $value['comment_email'] ?></td>
                        <td><?php echo $value['comment_body'] ?></td>
                        <td><?php echo convertDateToFarsi($value['comment_created_at']); ?></td>
                        <?php
                        if (isset($_GET['confirm'])) {
                            commentConfirm($_GET['confirm']);
                            header('location:Comments.php');
                        } elseif (isset($_GET['reject'])) {
                            commentReject($_GET['reject']);
                            header('location:Comments.php');
                        }
                        ?>
                        <td>
                            <?php
                            if ($value['comment_status'] == 0) {
                                ?>
                                <a class="status" href="Comments.php?confirm=<?php echo $value['comment_id'] ?>">تایید
                                    نظر</a>
                                <?php
                            } else {
                                ?>
                                <a class="delete" style="width: 75px;"
                                   href="Comments.php?reject=<?php echo $value['comment_id'] ?>">رد نظر</a>
                            <?php }
                            ?>
                        </td>
                        <td>
                            <?php
                            if (!$value['comment_reply']) {
                                ?>
                                <a class="answer" href="ReplyComment.php?comment_id=<?php echo $value['comment_id'] ?>">پاسخ
                                    به نظر</a>
                            <?php } else {
                                echo 'این پاسخ است';
                            }
                            ?>
                        </td>
                        
                        <td>
                            <a class="delete" href="Comments.php?delete=<?php echo $value['comment_id'] ?>">حذف</a>
                            <a class="edit" href="EditComment.php?edit=<?php echo $value['comment_id'] ?>">ویرایش</a>
                        </td>
                    </tr>
                <?php }
            } else {
                ?>
                <td colspan="9" class="alert alert-info">نظری وجود ندارد</td>

            <?php } ?>
            </tbody>
        </table>
    </div><!--- end Content --->
    <div class="clear"></div>
</div><!-- end body-->

<?php require_once 'pages/footer.php' ?>

