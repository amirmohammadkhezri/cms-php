<?php
function addCategory()
{
    global $con;
    if (isset($_POST['insertCategory'])) {
        $sql = "insert into `categories` (`cate_title`) values (:cate_title)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':cate_title', $_POST['cate_title']);
        if ($stmt->execute()) {
            return $stmt;
        } else {
            return false;
        }
    }

}

function selectAllCategory()
{
    global $con;
    $sql = "select * from `categories`";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount()) {
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    } else {
        return false;
    }
}

function deleteCategory($cate_id)
{
    global $con;
    if (isset($_GET['delete'])) {
        $sql = "delete from `categories`  where `cate_id`=?";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(1, $cate_id);
        $stmt->execute();
        if ($stmt->rowCount()) {
            return $stmt;
        } else {
            return false;
        }
    }
}

function selectCategory($cate_id)
{
    global $con;
    if (isset($_GET['edit'])) {
        $sql = "select * from `categories` where `cate_id`=?";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(1, $cate_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

function updateCategory($cate_id)
{
    global $con;
    $sql = "update `categories` set `cate_title`=? where `cate_id`=?";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(1, $_POST['cate_title']);
    $stmt->bindValue(2, $cate_id);
    $stmt->execute();
    if ($stmt->rowCount()) {
        return $stmt;
    } else {
        return false;
    }
}

function addPost()
{
    global $con;
    if (isset($_POST['insertPost'])) {
        $post_title = $_POST['post_title'];
        $post_category_id = $_POST['post_category_id'];
        $post_author = $_POST['post_author'];
        $post_body = $_POST['post_body'];
        $post_tags = $_POST['post_tags'];
        $post_created_at = date('y-m-d');
        $file = $_FILES['post_img']['name'];
//        var_dump($file);
        $extension = explode('.', $file); // lara.jpg lara.5.7.jpg
//        var_dump($extension);
        $fileExt = strtolower(end($extension));
//        var_dump($fileExt);
        $post_img = md5(microtime() . $file);
//        var_dump($post_img);
        $post_img .= "." . $fileExt;
//        var_dump($post_img);
        $error = $_FILES['post_img']['error'];
        $tmp_name = $_FILES['post_img']['tmp_name'];

        echo "<p class='alert alert-info'> پسوند فایل انتخابی شما : $fileExt </p>";

        switch ($error) {
            case UPLOAD_ERR_OK;
                $valid = true;
                if (!in_array($fileExt, array('png', 'jpg', 'gif', 'jepg'))) {
                    $valid = false;
                    echo '<p class="alert alert-warning">پسوند فایل انتخابی باید png , jpg , gif , jpeg باشد</p>';
                }
                if ($error > 200000) {
                    $valid = false;
                    echo '<p class="alert alert-warning">عکس انتخاب شده بیش از حد بزرگ است</p>';
                }
                if ($valid) {
                    $valid = true;
                    echo '<p class="alert alert-success">عکس با موفقیت اپلودشد</p>';
                    move_uploaded_file($tmp_name, '../images/' . $post_img);
                    $sql = 'INSERT INTO `posts` (`post_category_id`,`post_title`,`post_author`,`post_created_at`,`post_img`,`post_body`,`post_tags`)
                    values (:post_category_id,:post_title,:post_author,:post_created_at,:post_img,:post_body,:post_tags)';
                    $stmt = $con->prepare($sql);
                    $stmt->bindParam(':post_category_id', $post_category_id);
                    $stmt->bindParam(':post_title', $post_title);
                    $stmt->bindParam(':post_author', $post_author);
                    $stmt->bindParam(':post_created_at', $post_created_at);
                    $stmt->bindParam(':post_img', $post_img);
                    $stmt->bindParam(':post_body', $post_body);
                    $stmt->bindParam(':post_tags', $post_tags);
                    $stmt->execute();
                    if ($stmt->rowCount()) {
                        return $stmt;
                    } else {
                        return false;
                    }
                }
                break;
            case UPLOAD_ERR_PARTIAL;
                echo '<p class="alert alert-warning">بخشی از عکس اپلود نشده است</p>';
                break;
            case UPLOAD_ERR_NO_TMP_DIR;
                echo '<p class="alert alert-warning">عکست کجاست؟</p>';
                break;
            default:
                echo '<p class="alert alert-error">خطا در درج</p>';
                break;
        }

    }
}

function selectAllPost()
{
    global $con;
    global $count;

    if (!isset($_GET['page'])) {
        $offset = $_GET['page'] = 0;
    } else {
        $offset = ($_GET['page'] - 1) * 4;
//        3 -1= 2* 4 = 8
//        4 -1 = 3 * 4 =12
//        5 -1 = 3 * 4 =12
    }

    $sql = "select * from `posts`";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $count = $stmt->rowCount() / 8;
//    var_dump(ceil($count / 4));
//    die();

    $sql = "select * from `posts` limit {$offset},8";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount()) {
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    } else {
        return false;
    }
}

function convertDateToFarsi($value)
{

    $date = explode('-', $value);
//    var_dump($date);
    return gregorian_to_jalali($date[0], $date[1], $date[2], '/');
}

function showCategoryTitle($value)
{
    global $con;
    $sql = "select * from `categories` where `cate_id`=?";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(1, $value);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row as $valueCategory) {
        return $valueCategory['cate_title'];
    }
}

function deletePost($post_id)
{
    global $con;
    if (isset($_GET['delete'])) {
        $sql = "delete from `posts` where `post_id`=?";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(1, $post_id);
        $stmt->execute();
        if ($stmt->rowCount()) {
            return $stmt;
        } else {
            return false;
        }
    }
}

function selectPost($post_id)
{
    global $con;
    if (isset($post_id)) {
        $sql = "select * from `posts` where `post_id`=?";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(1, $post_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

function updatePost($post_id)
{
    global $con;
    if (isset($_POST['updatePost'])) {
        $post_title = $_POST['post_title'];
        $post_category_id = $_POST['post_category_id'];
        $post_author = $_POST['post_author'];
        $post_body = $_POST['post_body'];
        $post_tags = $_POST['post_tags'];
        $post_created_at = date('y-m-d');
        $file = $_FILES['post_img']['name'];
//        var_dump($file);
        $extension = explode('.', $file); // lara.jpg lara.5.7.jpg
//        var_dump($extension);
        $fileExt = strtolower(end($extension));
//        var_dump($fileExt);
        $post_img = md5(microtime() . $file);
//        var_dump($post_img);
        $post_img .= "." . $fileExt;
//        var_dump($post_img);
        $error = $_FILES['post_img']['error'];
        $tmp_name = $_FILES['post_img']['tmp_name'];

        echo "<p class='alert alert-info'> پسوند فایل انتخابی شما : $fileExt </p>";

        switch ($error) {
            case UPLOAD_ERR_OK;
                $valid = true;
                if (!in_array($fileExt, array('png', 'jpg', 'gif', 'jepg'))) {
                    $valid = false;
                    echo '<p class="alert alert-warning">پسوند فایل انتخابی باید png , jpg , gif , jpeg باشد</p>';
                }
                if ($error > 200000) {
                    $valid = false;
                    echo '<p class="alert alert-warning">عکس انتخاب شده بیش از حد بزرگ است</p>';
                }
                if ($valid) {
                    $valid = true;
                    echo '<p class="alert alert-success">عکس با موفقیت اپلودشد</p>';
                    move_uploaded_file($tmp_name, '../images/' . $post_img);
                    $sql = "update `posts` set `post_category_id`=:post_category_id,`post_title`=:post_title,`post_author`=:post_author,`post_created_at`=:post_created_at,`post_img`=:post_img,`post_body`=:post_body,`post_tags`=:post_tags where `post_id`=:post_id";
                    $stmt = $con->prepare($sql);
                    $stmt->bindParam(':post_category_id', $post_category_id);
                    $stmt->bindParam(':post_title', $post_title);
                    $stmt->bindParam(':post_author', $post_author);
                    $stmt->bindParam(':post_created_at', $post_created_at);
                    $stmt->bindParam(':post_img', $post_img);
                    $stmt->bindParam(':post_body', $post_body);
                    $stmt->bindParam(':post_tags', $post_tags);
                    $stmt->bindParam(':post_id', $post_id);
                    $stmt->execute();
                    if ($stmt->rowCount()) {
                        return $stmt;
                    } else {
                        return false;
                    }
                }
                break;
            case UPLOAD_ERR_PARTIAL;
                echo '<p class="alert alert-warning">بخشی از عکس اپلود نشده است</p>';
                break;
            case UPLOAD_ERR_NO_TMP_DIR;
                echo '<p class="alert alert-warning">عکست کجاست؟</p>';
                break;
            default:
                echo '<p class="alert alert-error">خطا در درج</p>';
                break;
        }

    }

}


function searchPost($title)
{
    global $con;
//    $sql = "select * from `posts` where `post_tag` LIKE '%$title%' ";
    $sql = 'select * from `posts` where `post_tags` LIKE ?';
    $stmt = $con->prepare($sql);
    $stmt->bindValue(1, "%$title%");
    $stmt->execute();
    if ($stmt->rowCount() >= 1) {
        return $row = $stmt->fetchAll(PDO::FETCH_OBJ);
    } else {
        return false;
    }
}
function showSinglePost($item)
{
    global $con;
    if (isset($item)) {
        $sql = "select * from `posts` where `post_id`=?";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(1, $item);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

function readMore($value)
{
    return mb_substr($value, 0, 155, 'utf-8') . ' ... ';
}

function selectCategoryByPost($value)
{
    global $con;
    if (isset($value)) {
        $sql = "select * from `posts` where `post_category_id`=?";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(1, $value);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

function sendComment()
{
    global $con;
    if (isset($_POST['sendComment'])) {
        $comment_created_at = date('y-m-d');
        $sql = "INSERT INTO `comments` (`comment_post_id`,`comment_author`,`comment_body`,`comment_email`,`comment_created_at`) values (:comment_post_id,:comment_author,:comment_body,:comment_email,:comment_created_at)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':comment_post_id', $_GET['post_id']);
        $stmt->bindParam(':comment_author', $_POST['comment_author']);
        $stmt->bindParam(':comment_body', $_POST['comment_body']);
        $stmt->bindParam(':comment_email', $_POST['comment_email']);
        $stmt->bindParam(':comment_created_at', $comment_created_at);
        $stmt->execute();
        if ($stmt->rowCount()) {
            return $stmt;
        } else {
            return false;
        }
    }
}

function selectAllComment()
{
    global $con;
    $sql = "select * from `comments`";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}

function showPostForComment($value)
{
    global $con;
    $sql = "select * from `posts` where `post_id`=:comment_post_id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':comment_post_id', $value);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row as $valuePost) {
        return $valuePost['post_title'];
    }
}

function commentConfirm($comment_id)
{
    global $con;
    $sql = "update `comments` set `comment_status`=? where comment_id=?";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(1, 1);
    $stmt->bindValue(2, $comment_id);
    return $stmt->execute();

}

function commentReject($comment_id)
{
    global $con;
    $sql = "update `comments` set `comment_status`=? where comment_id=?";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(1, 0);
    $stmt->bindValue(2, $comment_id);
    return $stmt->execute();

}

function selectComment($comment_id)
{
    global $con;

    if (isset($comment_id)) {
        $sql = "select * from `comments` where `comment_id`=?";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(1, $comment_id);
        $stmt->execute();
        return $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

function sendReplyComment($comment_id, $comment_post_id)
{
    global $con;
    if (isset($_POST['sendReplyComment'])) {
        $comment_created_at = date('y-m-d');
        $comment_author = 'مدیر سایت';
        $comment_email = 'admin@gmail.com';
        $comment_status = 1;
        $sql = "INSERT INTO `comments` (`comment_post_id`,`comment_author`,`comment_body`,`comment_status`,`comment_email`,`comment_created_at`,`comment_reply`)
        values (:comment_post_id,:comment_author,:comment_body,:comment_status,:comment_email,:comment_created_at,:comment_reply)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':comment_post_id', $comment_post_id);
        $stmt->bindParam(':comment_author', $comment_author);
        $stmt->bindParam(':comment_body', $_POST['comment_body']);
        $stmt->bindParam(':comment_status', $comment_status);
        $stmt->bindParam(':comment_email', $comment_email);
        $stmt->bindParam(':comment_created_at', $comment_created_at);
        $stmt->bindParam(':comment_reply', $comment_id);
        $stmt->execute();
        if ($stmt->rowCount()) {
            return $stmt;
        } else {
            return false;
        }

    }
}

function deleteComment($comment_id)
{
    global $con;
    $sql = "delete from `comments` where `comment_id`=?";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(1, $comment_id);
    $stmt->execute();
    if ($stmt->rowCount()) {
        return $stmt;
    } else {
        return false;
    }
}

function editComment($comment_id)
{
    global $con;
    if (isset($_POST['editComment'])) {
        $comment_created_at = date('y-m-d');
        $sql = "update `comments` set `comment_body`=:comment_body,`comment_created_at`=:comment_created_at where `comment_id`=:comment_id";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':comment_body', $_POST['comment_body']);
        $stmt->bindParam(':comment_created_at', $comment_created_at);
        $stmt->bindParam('comment_id', $comment_id);
        $stmt->execute();
        if ($stmt->rowCount()) {
            return $stmt;
        } else {
            return false;
        }

    }
}

function showQuesion($comment_post_id)
{
    global $con;
    $sql = "select * from `comments` where `comment_status`=?  and `comment_post_id`=? and `comment_reply`=?";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(1, 1);
    $stmt->bindValue(2, $comment_post_id);
    $stmt->bindValue(3, 0);
    $stmt->execute();
    if ($stmt->rowCount()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}

function showCommentReply($comment_id)
{
    global $con;
    $sql = "select * from `comments` where `comment_reply`=?";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(1, $comment_id);
    $stmt->execute();
    if ($stmt->rowCount()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}

function LoginCheck()
{
    global $con;
    if (isset($_POST['Login'])) {
        $sql = "select * from `admins` where `admin_username`=? and `admin_password`=?";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(1, $_POST['admin_username']);
        $stmt->bindValue(2, md5($_POST['admin_password']));
        $stmt->execute();
        if ($stmt->rowCount()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['AdminId'] = [
                'admin_id' => $row['admin_id'],
                'admin_username' => $row['admin_username']
            ];
            header('location:admin/');
//            $_SESSION['adminId']=$row['admin_id'];
//            $_SESSION['admin_username']=$row['admin_username'];
        } else {
            header('location:Login.php?Login=error');
        }
    }
}