<?php require_once 'pages/header.php' ?>
<div class="body"><!-- start body-->
    <?php require_once 'pages/sidebar.php' ?>

    <div class="content"> <!--- start Content --->
        <?php addPost(); ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" class="textbox" required="required" name="post_title" placeholder="عنوان مطلب">
            <select name="post_category_id" class="textbox" required="required">
                <?php
                $selectAllCategory = selectAllCategory();
                foreach ($selectAllCategory as $valueCategory) {
                    echo "<option value='" . $valueCategory->cate_id . "'>{$valueCategory->cate_title}</option>";
                }
                ?>
            </select>
            <input type="text" name="post_author" class="textbox" placeholder="نویسنده مطلب" required="required">
            <style>
                /*.selectPic {*/
                /*background: #45a9ff;*/
                /*width: 20%;*/
                /*margin-bottom: 5px;*/
                /*height: 38px;*/
                /*border-radius: 2px;*/
                /*padding: 5px 20px;*/
                /*color: #fff;*/
                /*font-size: 17px;*/
                /*cursor: pointer;*/
                /*}*/

                /*.selectPic input {*/
                /*opacity: 0;*/
                /*}*/
            </style>
            <div class="selectPic">
                <input type="file" name="post_img" class="textbox" >
            </div>

            <textarea name="post_body" required="required" class="textbox" style="height: 230px;padding: 15px;"
                      placeholder="توضیحات مطلب"></textarea>
            <input type="text" name="post_tags" required="required" class="textbox" placeholder="برچسب ها">
            <br>
            <input type="submit" class="btn btn-success" name="insertPost" value="درج مطلب">
            <input type="reset" class="btn btn-error" n value="انصراف">
        </form>

    </div><!--- end Content --->
    <div class="clear"></div>
</div><!-- end body-->

<?php require_once 'pages/footer.php' ?>

