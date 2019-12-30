<?php
$Option = [
    PDO::ATTR_PERSISTENT => TRUE,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];
try {
    $con = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '', $Option);
//    $sql = 'select * from `posts`';
//    $stmt = $con->query($sql);
//    var_dump($row = $stmt->fetch(PDO::FETCH_ASSOC));
//    echo $row['post_title'];
//    echo $row[2];
//    $Error = $con->errorInfo();
////    var_dump($Error);
//    if (isset($Error[2])) {
//        var_dump($Error);
//    } else {
//        var_dump($stmt->fetch());
//    }

} catch (PDOException $error) {
    echo 'Error' . $error->getMessage();
}