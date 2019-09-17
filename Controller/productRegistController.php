<?php 
include '../Model/db_Processing.php';
session_start();

$db_con = new mysqli(DB_info::DB_URL, DB_info::DB_HOST, DB_info::DB_PW, DB_info::DB_NAME);

$process_query = new process();

//DB Connect Error Exception
if($db_con->connect_error){
  die("Failed to connet to DataBase".$db_con->connet_error);
}
$db_con->set_charset("utf8");
// product name
$name  = $_POST["p_name"];
// product price
$price = $_POST["p_price"];
// product memo
$memo  = $_POST["p_memo"];

// local path
$uploadDir = 'C:\dev\New-ECMall\Public\img';

// server path
// $uploadDir = 'cd /var/www/html/';

$allowedExt = array('jpg', 'jpeg', 'png', 'gif');
$error = $_FILES['p_img']['error'];
$fileName = $_FILES['p_img']['name'];

if($fileName == NULL) {
    $process_query->insert("product_list","(LAST_INSERT_ID(),'$name','$memo','$price', '')");
    echo "<script>window.location.replace('../View/main.php')</script>";
    return;
} 

$process_query->insert("product_list","(LAST_INSERT_ID(),'$name','$memo','$price', '$fileName')");

// create file in the path folder
if( $error != UPLOAD_ERR_OK){
    switch($error){
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            echo "file is too big ($error)";
            break;
        case UPLOAD_ERR_NO_FILE:
            echo "file is not uploaded ($error)";
            break;
            default:
                echo "file is not correctly uploaded ($error)";
    }
    exit;
}

$makeImgFile = move_uploaded_file($_FILES['p_img']['tmp_name'], "$uploadDir/$fileName");

if(!$makeImgFile) {
    echo "<script>alert('エラーが出てきました。')</script>";
    echo "<script>history.back();</script>";
}


echo "<script>window.location.replace('../View/main.php')</script>";


?>