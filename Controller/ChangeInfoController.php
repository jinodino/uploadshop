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


// print_r($_POST['name']);
// print_r($_POST['price']);
// print_r($_POST['memo']);

$num = $_POST['num'];

$name = $_POST['name'];

$price = $_POST['price'];

$memo = $_POST['memo'];

// local path
$uploadDir = 'C:\dev\New-ECMall\Public\img';

// server path
// $uploadDir = 'cd /var/www/html/';
if(!isset($_FILES['file'])) {

    $process_query->updateNoFileName("product_list", $num, $name, $price, $memo);

} else {
    $fileName = $_FILES['file']['name'];
    $allowedExt = array('jpg', 'jpeg', 'png', 'gif');
    $error = $_FILES['file']['error'];
    $fileName = $_FILES['file']['name'];

    $process_query->update("product_list", $num, $name, $price, $memo, $fileName);

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

    $makeImgFile = move_uploaded_file($_FILES['file']['tmp_name'], "$uploadDir/$fileName");
}


echo "../Public/img/$fileName";







?>