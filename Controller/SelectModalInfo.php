<?php
include '../Model/db_Processing.php';
session_start();

$today = date('Ymdhis');
$process_query = new process();

$db_con = new mysqli(DB_info::DB_URL, DB_info::DB_HOST,
                      DB_info::DB_PW, DB_info::DB_NAME);
$db_con->set_charset("utf8");
//DB Connect Error Exception
if($db_con->connect_error){
  die("Failed to connet to DataBase".$db_con->connet_error);
}


$id             = $_POST['id'];
$classification = $_POST['classification'];

if($classification == "product") {

    $query  = "SELECT * FROM ecmall.product_list WHERE p_num = '$id'";

    $result = mysqli_query($db_con, $query);

    $row    = mysqli_fetch_assoc($result);

    echo json_encode($row);
} 
else if ($classification == "customer") {

    $query    = "SELECT * FROM ecmall.user_list WHERE user_id = '$id'";

    $result   =   mysqli_query($db_con, $query);

    $row      =   mysqli_fetch_assoc($result);

    if($row["user_qualify"] == 1) {
        $qualify = "Customer";
    } else {
        $qualify = "Manager";
    }

    $customerInfo = array(
        'userId'    => $row["user_id"],
        'userName'  => $row["user_name"],
        'userPhone' => $row["user_mobile"],
        'userclass'  => $qualify
    );


    $query    = "SELECT 
                    c.order_num, u.user_id, c.customer_address, c.customer_postnum
                    FROM
                    ecmall.customer_list as c, ecmall.user_list as u
                    WHERE
                    c.user_num = u.user_num
                    AND 
                    u.user_id = '" . $row["user_id"] . "'
                ";

    $result   =   mysqli_query($db_con, $query);

    $row      =   mysqli_fetch_all($result);

    $result = array(
        'userInfo'  => $customerInfo,
        'orderInfo' => $row,
    );
    // echo $query;
    echo json_encode($result);

}


?>