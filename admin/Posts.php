<?php require_once 'pages/header.php' ?>
<div class="body"><!-- start body-->
    <?php require_once 'pages/sidebar.php' ?>

    <div class="content"> <!--- start Content --->
        <p class="alert alert-info">لیست مطالب</p>

        <?php
        if (isset($_GET['delete'])) {
            $row = selectPost($_GET['delete']);
            $delete = deletePost($_GET['delete']);
            if ($delete) {
                $post_img = "../images/" . $row['post_img'];
                unlink($post_img);
                header('location:Posts.php?success=true');
            } else {
                header('location:Posts.php?error=true');
//                echo 'error';
            }
        }
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
                <th>عنوان</th>
                <th>دسته بندی</th>
                <th>نویسنده</th>
                <th>تاریخ</th>
                <th>تصویر</th>
                <th>برچسب</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            <?php $selectAllPost = selectAllPost();

            if ($selectAllPost) {
                foreach ($selectAllPost as $index => $value) {
                    ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $value->post_title ?></td>
                        <td><?= showCategoryTitle($value->post_category_id) ?></td>
                        <td><?= $value->post_author ?></td>
                        <td><?= convertDateToFarsi($value->post_created_at); ?></td>
                        <td><img width="160px" height="90px" src="../images/<?= $value->post_img ?>" alt=""></td>
                        <td><?= $value->post_tags ?></td>
                        <td>
                            <a class="delete" href="Posts.php?delete=<?php echo $value->post_id ?>">حذف</a>
                            <a class="edit" href="EditPost.php?edit=<?php echo $value->post_id ?>">ویرایش</a>
                        </td>
                    </tr>
                <?php }
            } else {
                ?>
                <td colspan="8" class="alert alert-info">مطلبی وجود ندارد</td>


            <?php }

            ?>
            </tbody>
        </table>
        <?php

        for ($i = 1; $i <= $count; $i++) {
            if ($i == $_GET['page']) {
                echo '<a href="Posts.php?page=' . $i . '" class="paginate active">' . $i . '</a>';
            } else {
                echo '<a href="Posts.php?page=' . $i . '" class="paginate">' . $i . '</a>';
            }
        }

        ?>
    </div><!--- end Content --->
    <div class="clear"></div>
</div><!-- end body-->

<?php require_once 'pages/footer.php' ?>

