<?php require_once 'pages/header.php' ?>
<div class="body"><!-- start body-->
    <?php require_once 'pages/sidebar.php' ?>
    <?php
    $row = selectPost($_GET['edit']);
    //    var_dump($row);
    if (isset($_GET['edit']) && isset($_POST['post_id'])) {

        $updatePost = updatePost($_POST['post_id']);
        if ($updatePost) {
            $post_img = "../images/" . $row['post_img'];
//            var_dump($post_img);
            unlink($post_img);
            $message = '<p class="alert alert-success">ویرایش با موفقیت انجام شد</p>';
            header("refresh:1, url = Posts.php");
        } else {
            $message = '<p class="alert alert-error">ویرایش با خطا مواجه شد</p>';
        }
    }
    ?>
    <div class="content"> <!--- start Content --->
        <?php if (isset($message)) echo $message; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" value="<?php echo $row['post_title'] ?>" class="textbox" required="required"
                   name="post_title" placeholder="عنوان مطلب">
            <select name="post_category_id" class="textbox" required="required">
                <?php
                $selectAllCategory = selectAllCategory();
                foreach ($selectAllCategory as $value) {
                    ?>
                    <option value="<?= $value->cate_id; ?>" <?php if ($row['post_category_id'] == $value->cate_id) {
                        echo 'selected';
                    } ?>>
                        <?php echo $value->cate_title; ?>
                    </option>
                <?php }
                ?>
            </select>
            <input type="text" value="<?php echo $row['post_author'] ?>" name="post_author" class="textbox"
                   placeholder="نویسنده مطلب" required="required">

            <input type="file" name="post_img" class="textbox">
            <div class="">
                <img width="200px" height="110px" src="../images/<?php echo $row['post_img'] ?>" alt="">
            </div>
            <textarea name="post_body" required="required" class="textbox" style="height: 230px;padding: 15px;"
                      placeholder="توضیحات مطلب"><?php echo $row['post_body'] ?></textarea>
            <input type="text" value="<?php echo $row['post_tags'] ?>" name="post_tags" required="required"
                   class="textbox" placeholder="برچسب ها">
            <input type="text" name="post_id" value="<?php echo $row['post_id'] ?>" class="textbox" placeholder="">
            <br>
            <input type="submit" class="btn btn-success" name="updatePost" value="ویرایش مطلب">
            <input type="reset" class="btn btn-error" n value="انصراف">
        </form>

    </div><!--- end Content --->
    <div class="clear"></div>
</div><!-- end body-->

<?php require_once 'pages/footer.php' ?>

