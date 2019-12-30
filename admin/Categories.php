<?php require_once 'pages/header.php' ?>
<div class="body"><!-- start body-->
    <?php require_once 'pages/sidebar.php' ?>

    <?php
    if (isset($_GET['delete'])) {
        $deleteCategory = deleteCategory($_GET['delete']);
        if ($deleteCategory) {
            header('location:Categories.php?success=ok');
        } else {
            header('location:Categories.php?error=ok');
        }

    }
    addCategory()
    ?>
    <div class="content"> <!--- start Content --->
        <form action="" method="post">
            <input type="text" class="textbox" name="cate_title" placeholder="نام دسته بندی">
            <br>
            <input type="submit" class="btn btn-success" name="insertCategory" value="درج دسته بندی">
            <input type="reset" class="btn btn-error" value="انصراف">
        </form>
        <?php
        if (isset($_GET['success'])) {
            echo '<p class="alert alert-success">حذف با موفقیت انجام شد</p>';
        } elseif (isset($_GET['error'])) {
            echo '<p class="alert alert-error">حذف با  خطا مواجه شد</p>';
        }
        ?>
        <table>
            <thead>
            <tr>
                <th>شناسه</th>
                <th>نام دسته بندی</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $selectCategory = selectAllCategory();
            if ($selectCategory) {
                foreach ($selectCategory as $index => $value) {
                    ?>
                    <tr>
                        <td><?php echo $index + 1 ?></td>
                        <td><?= $value->cate_title ?></td>
                        <td>
                            <a class="delete" href="Categories.php?delete=<?= $value->cate_id; ?>">حذف</a>
                            <a class="edit" href="EditCategory.php?edit=<?= $value->cate_id ?>">ویرایش</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <td colspan="3" class="alert alert-info">دسته ای وجود ندارد</td>
            <?php } ?>

            </tbody>
        </table>
    </div><!--- end Content --->
    <div class="clear"></div>
</div><!-- end body-->

<?php require_once 'pages/footer.php' ?>

