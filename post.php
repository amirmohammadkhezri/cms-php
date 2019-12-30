<?php require_once 'includes/init.php' ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>وبلاگ من</title>
</head>

<body>
    <div class="header">
        <!-- start header-->
        <div class="contanier">
            <!-- start contanier-->
            <ul class="menu">

                <?php
                $showCategory = selectAllCategory();
                foreach ($showCategory as $value) {
                    echo "<li><a href='categories.php?cate_id={$value->cate_id}'>{$value->cate_title}</a></li>";
                }
                ?>

                <li><a href="admin">ورود مدیریت</a></li>
                <li class="logo"><a href="./"><img src="images/weblogo.png"></a></li>
            </ul>
            <div class="clear"></div>
        </div><!-- end contanier-->

        <div class="HeaderPic">
            <!-- end HeaderPic-->
            <img src="images/bgtop.jpg">

            <form action="search.php" method="post">
                <div class="search">
                    <!-- end search-->
                    <input type="text" name="search" class="inputSearch" placeholder="جستجو کنید ">
                    <button class="searchBtn" name="btnSearch">جستجو</button>
                    <div class="clear"></div>
                </div><!-- end search-->
            </form>
            <div class="clear"></div>
        </div><!-- end HeaderPic-->

        <div class="clear"></div>
    </div><!-- end header-->
    <div class="body">
        <!-- start body-->
        <div class="contanier" style="display: flex;flex-direction: column">
            <!-- start contanier-->
            <?php
            if (isset($_GET['post_id'])) {
                $showSinglePost = showSinglePost($_GET['post_id']);
            }

            if ($showSinglePost) {
                foreach ($showSinglePost as $value) {
            ?>
                    <div class="post" style="width: 70%;align-self: center">
                        <!-- start post-->
                        <div class="postHeader">
                            <!-- start postHeader-->
                            <h1 class="postTitle"><a href="post.php?post_id=<?php echo $value->post_id ?>"><?php echo $value->post_title ?></a>
                            </h1>
                            <span> تاریخ انتشار : <?= convertDateToFarsi($value->post_created_at); ?> </span>
                            <div class="clear"></div>
                        </div><!-- end postHeader-->
                        <div class="postBody">
                            <!-- start postBody-->
                            <div class="postPic" style="height: auto">
                                <!-- start postPic-->
                                <img src="images/<?php echo $value->post_img ?>">
                            </div><!-- end postPic-->
                            <div class="postDesc">
                                <!-- start postHeader-->
                                <?php echo $value->post_body ?>
                            </div><!-- end postDesc-->
                            <div class="clear"></div>
                        </div><!-- end postBody-->
                        <div class="postFooter">
                            <!-- start postFooter-->
                            <span>نویسنده مطلب :<?php echo $value->post_author ?> </span>

                            <div style="float: left">
                                <?php
                                $tags = explode(',', $value->post_tags);

                                foreach ($tags as $value) {
                                    echo "<span class='tags'>$value</span>";
                                }
                                ?>
                            </div>
                            <div class="clear"></div>

                        </div><!-- end postHeader-->

                        <div class="clear"></div>

                    </div><!-- end post-->

            <?php }
            } else {
                echo '<p class="alert alert-info">مطلبی وجود ندارد</p>';
            } ?>
            <?php sendComment(); ?>
            <div class="sendComment">
                <!-- start sendComment-->
                <div class="commentHeader">
                    <!-- start commentHeader-->
                    <h1>ارسال نظر</h1>
                </div><!-- end commentHeader-->
                <div class="commentBody">
                    <!-- start commentBody-->
                    <form action="" method="post">
                        <input type="text" name="comment_author" required="required" class="textbox" placeholder="نویسنده">
                        <input type="text" name="comment_email" required="required" class="textbox" placeholder="ایمیل">
                        <textarea required="required" name="comment_body" class="textbox" style="height: 150px;resize: none;padding: 12px" placeholder="نظر خود را بنویسد"></textarea>
                        <br>
                        <input type="submit" name="sendComment" class="btn btn-success" value="ارسال نظر">
                        <input type="reset" class="btn btn-error" value="انصراف">
                    </form>
                </div><!-- end commentBody-->
                <div class="commentFooter">
                    <?php
                    $showQuestion = showQuesion($_GET['post_id']);
                    if ($showQuestion) {
                        foreach ($showQuestion as $value) {
                    ?>
                            <div class="answerCommnet">
                                <div class="info">
                                    <span class="comment_author"> کاربر : <?php echo $value['comment_author'] ?> گفته : </span>
                                    <span class="comment_date"> تاریخ : <?= convertDateToFarsi($value['comment_created_at']); ?> </span>
                                    <div class="clear"></div>
                                </div>
                                <div class="">
                                    <p class="commentQ">
                                        <?php echo $value['comment_body'] ?>
                                    </p>
                                </div>
                                <?php

                                $showCommentReply = showCommentReply($value['comment_id']);
                                if ($showCommentReply) {
                                    foreach ($showCommentReply as $item) {
                                ?>
                                        <div class="divAdminReply">
                                            <div class="info">
                                                <span class="comment_author" style="color: blue">مدیر سایت گفته : </span>
                                                <span class="comment_date"> تاریخ : <?= convertDateToFarsi($item['comment_created_at']); ?> </span>
                                                <div class="clear"></div>
                                            </div>
                                            <p class="AdminReply">
                                                <?php echo $item['comment_body'] ?>
                                            </p>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                    <?php }
                    } else {
                        echo '<p class="alert alert-info">نظری برای این پست ثبت نشده است</p>';
                    } ?>
                </div>
                <div class="clear"></div>
            </div><!-- end sendComment-->

            <div class="clear"></div>
        </div><!-- end body-->
        <div class="clear"></div>
    </div><!-- end body-->
    <div class="footer">
        <!-- end footer-->
        <p>Amir Mohammad Khezri</p>
    </div><!-- end header-->

</body>

</html>