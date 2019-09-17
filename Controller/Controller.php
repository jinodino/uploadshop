<?php
include '../Model/db_Processing.php';
session_start();

$function = $_POST['function'];
$today = date('Ymdhis');
$process_query = new process();

$db_con = new mysqli(DB_info::DB_URL, DB_info::DB_HOST,
                      DB_info::DB_PW, DB_info::DB_NAME);

//DB Connect Error Exception
if($db_con->connect_error){
  die("Failed to connet to DataBase".$db_con->connet_error);
}
$db_con->set_charset("utf8");

/*********************************************************************/
/*********************************************************************/
/************ Receive function value to execute each process *********/
/*********************************************************************/
/*********************************************************************/


if($function == "login"){
  $user_pw = $_POST['user_pw'];
  $user_id = $_POST['user_id'];

  $sql = "select * from user_list where user_id = '$user_id'";

  $result = mysqli_query($db_con, $sql);
  $row = mysqli_fetch_assoc($result);


  //Doesn't Input Value Exception
  if(($user_id == NULL)||($user_pw == NULL)){
      echo "<script>alert('Input the Value')</script>";
      echo "<script>location.href = './main.php'</script>";
    }

//Doesn't Exist ID Exception
if($row['user_id'] == ''){
    echo "<script>alert('Doesn't Exist ID. Join plz')</script>";
    echo "<script>location.href = '../View/main.php'</script>";
}

//Correct to Login information
if($user_id == $row['user_id']){

  if ($user_pw == $row['user_pw'] )
  {

   $_SESSION['user_id'] = $row['user_id'];
   $_SESSION['user_pw'] = $row['user_pw'];
   $_SESSION['user_name'] = $row['user_name'];
   $_SESSION['user_qualify'] = $row['user_qualify'];
   echo "<script>alert('Login success! $today')</script>";
  }

  elseif ($user_pw == NULL) {
    echo "<script>alert('input the Password')</script>";
  }

//Exist ID, Wrong Password Exception
  elseif($user_pw != $row['user_pw']){
    echo "<script>alert('Wrong Password. try again')</script>";
  }

echo "<script>location.href ='../View/main.php'</script>";
}
}//End of Login Exception


/*********************************************************************/
/*********************************************************************/

if($function == "join"){

  $joinID = $_POST['joinID'];
  $joinPW = $_POST['joinPW'];
  $joinNM = $_POST['joinNM'];
  $joinMB = $_POST['joinMB'];

if(($joinID == NULL) || ($joinPW == NULL) || ($joinMB == NULL) || ($joinNM == NULL)){
  echo "<script>alert('input the Value')</script>";
  echo "<script>self.close()</script>";
}

else{


$query = $process_query->insert("user_list", "(LAST_INSERT_ID(),'$joinID','$joinPW','$joinNM','$joinMB','1')");

$result  = mysqli_query($db_con, $query);


if(isset($result)){
  echo "<script>window.alert('Success to Register. Login please!')</script>";
  echo "<script>self.close()</script>";
}

}
}

if($function == "logout"){
  session_destroy();
  echo "<script>location.href ='../View/main.php'</script>";

}
/*****************Processing user-related tasks***********************/
/*********************************************************************/


/*********************************************************************/
/*****************Processing product-related tasks********************/

if($function == "product_register"){

$p_name   = $_POST['p_name'];
$p_memo   = $_POST['p_memo'];
$p_price  = $_POST['p_price'];
$p_img    = $_FILES['p_img'];

$dir = '../Public/img';
$img_name = date('YmdHi').".png";

//Save image to path folder and database
if(move_uploaded_file($_FILES['p_img']["tmp_name"], "$dir/$img_name")){

  $query =
  $process_query->insert("product_list","(LAST_INSERT_ID(),'$p_name','$p_memo','$p_price','$img_name')");
};

echo "<script>alert('Register Complete')</script>";
echo "<script>self.close()</script>";
}



if($function=="purchase"){

/* Receive value from product_Purchase file */
$user_num = $_POST['user_num'];
$p_num = $_POST['p_num'];
$p_count = $_POST['p_count'];
$p_payment = $_POST['payment'];
$p_deliveryDate = $_POST['deliveryDate'];
$p_money = $_POST['p_money'];

$customer_name = $_POST['customer_name'];
$customer_mobile = $_POST['customer_mobile'];
$customer_postnum = $_POST['customer_postnum'];
$customer_address = $_POST['customer_address'];
$order_date = date('ymd');
global $today;

/* Insert order information in order_list table */
/* do not allowed duplicate */
$process_query->insert("order_list","('$today','$user_num','$p_num','$p_count','$p_money', '$p_payment','$p_deliveryDate', '$order_date')");



/*Insert orderer information in customer_list table*/
/*  duplicate allowed */
$process_query->insert("customer_list", "('$today', '$user_num', '$customer_name','$customer_mobile','$customer_postnum','$customer_address' )");


echo "<script>alert('Order Complete! Thank you for your purchase :) you can check order in mypage')</script>";
echo "<script>location.href = '../View/main.php'</script>";
}



if($function == "popularProduct") {
    // $query    =   "select * from product_list where p_num=9";
    $query    = "select 
                    o.p_num, count(*) as popular, p.p_name, p.p_img, p.p_memo, p.p_price
                  from
                    order_list as o, product_list as p
                  where
                    o.p_num = p.p_num
                  group by
                    o.p_num
                  order by
                    popular desc
                  limit 4";
    $result   =   mysqli_query($db_con,$query);
    $user_num_query = "select user_num from user_list where user_id = '". $_SESSION['user_id']."'" ;
    $user_num_result = mysqli_query($db_con,$user_num_query);
    $user_num_row = mysqli_fetch_array($user_num_result);
    
    $contents = "";
    while($row  =   mysqli_fetch_array($result)) {
      // print_r($row);
      $contents .= "<form method='post' class='Speed_Purchasing'>";
      $contents .= "    <div class='col-xs-3 col-md-3' style='margin:0px;'>";
      $contents .= "        <div class='thumbnail'>";
      $contents .= "            <input type='hidden' name='p_num' value=" . $row['p_num'] . "/>" ;
      $contents .= "            <input type='hidden' name='p_count' value='1'/>";
      $contents .= "            <input type='hidden' name='p_price'  value=" . $row['p_price'] . "/>";
      $contents .= "            <input type='hidden' name='user_num' value=" . $user_num_row['user_num'] . "/>";
      $contents .= "            <input type='hidden' name='user_id' value=" . $_SESSION['user_id'] . "/><input type='hidden' name='user_name' value=" . $_SESSION['user_name'] . "/>";
      $contents .= "            <img src='../Public/img/" . $row['p_img'] . "'>";
      $contents .= "            <div class='caption'>";
      $contents .= "                <h3><strong>" . $row['p_name'] . "</strong></h3>";
      $contents .= "                <p>" . $row['p_memo'] . "</p>";
      $contents .= "                <b>" . $row['p_price'] . "円</b><br><br>";
      $contents .= "                <input type='submit' button class='btn btn-warning btn-lg' value= 'Buy' onclick='Go_Purchase()'>";
      $contents .= "                <input type='image' button class='btn btn-success btn-lg' src='../Public/img/KAGO2.png' onclick='Go_Cart()'>";
      $contents .= "            </div>";
      $contents .= "        </div>";
      $contents .= "   </div>";
      $contents .= "</form>";
    }
    


    echo $contents;

    
}





if($function == "listupInfo") {


    $productListUpContents  = "";
    $customerListUpContents = "";
    $query    = "select 
          *
        from
          product_list
        order by
          p_num desc
        limit 0, 5";
        

    $result   =   mysqli_query($db_con, $query);

    
    while($row  =   mysqli_fetch_array($result)) {
      // $productListUpContents .= "<tr onclick='modalInfo(this);'  name='productModal' id='" . $row['p_num'] . "'>";
      $productListUpContents .= "<tr data-toggle='modal' data-target='#productModal' onclick='selectInfo(id)'  name='productModal' id='product-" . $row['p_num'] . "'>";
      $productListUpContents .= "    <th scope='row'>" . $row['p_num'] . "</th>";
      $productListUpContents .= "    <td>" . $row['p_name'] . "</td>";
      $productListUpContents .= "    <td>" . $row['p_price'] . "</td>";
      $productListUpContents .= "</tr>";
    }

    $query    = "select 
          *
        from
          user_list
        order by
          user_num desc
        limit 0, 5";

    $result   =   mysqli_query($db_con, $query);
    
    while($row  =   mysqli_fetch_array($result)) {
        // $customerListUpContents .= "<tr onclick='modalInfo(this);'   name='customerModal' id='" . $row['user_id'] . "'>";
        $customerListUpContents .= "<tr data-toggle='modal' data-target='#customerModal' onclick='selectInfo(id)'  name='customerModal' id='customer-" . $row['user_id'] . "'>";
        $customerListUpContents .= "    <th scope='row'>" . $row['user_num'] . "</th>";
        $customerListUpContents .= "    <td>" . $row['user_id'] . "</td>";
        $customerListUpContents .= "    <td>" . $row['user_name'] . "</td>";
        $customerListUpContents .= "</tr>";
    }


    // pagination

    $productpaginationContents = "";
    $productpaginationContents .= "<nav aria-label='Page navigation example'>";
    $productpaginationContents .= "  <ul class='pagination'>";

    $productpaginationContents .= "    <li class='page-item'>";
    $productpaginationContents .= "      <a class='page-link' href='#' aria-label='Previous' onclick='nextPage(this)' value='0' name='product'>";
    $productpaginationContents .= "        <span aria-hidden='true'>&laquo;</span>";
    $productpaginationContents .= "        <span class='sr-only'>Previous</span>";
    $productpaginationContents .= "      </a>";
    $productpaginationContents .= "    </li>";
    
  
    $query    = "select 
                  *
                from
                  product_list";

    $result = mysqli_query($db_con, $query);
    $numRow = ceil(mysqli_num_rows($result) / 5) - 1;

    if($numRow > 5) {
      for ($i=0; $i < 5; $i++) { 
        $productpaginationContents .= "<li class='page-item'><a class='page-link' onclick='nextPage(this)' value='$i' name='product'>" . ($i + 1) . "</a></li>";
      }
    } else {
      for ($i=0; $i <= $numRow; $i++) { 
        $productpaginationContents .= "<li class='page-item'><a class='page-link' onclick='nextPage(this)' value='$i' name='product'>" . ($i + 1) . "</a></li>";
      }
    }

    

    $productpaginationContents .= "    <li class='page-item'>";
    $productpaginationContents .= "      <a class='page-link' href='#' aria-label='Next' onclick='nextPage(this)' value='" . $numRow . "' name='product'>";
    $productpaginationContents .= "        <span aria-hidden='true'>&raquo;</span>";
    $productpaginationContents .= "        <span class='sr-only'>Next</span>";
    $productpaginationContents .= "      </a>";
    $productpaginationContents .= "    </li>";
    $productpaginationContents .= "  </ul>";
    $productpaginationContents .= "</nav>";

    // customer

    $customerpaginationContents = "";
    $customerpaginationContents .= "<nav aria-label='Page navigation example'>";
    $customerpaginationContents .= "  <ul class='pagination'>";

    $customerpaginationContents .= "    <li class='page-item'>";
    $customerpaginationContents .= "      <a class='page-link' href='#' aria-label='Previous' onclick='nextPage(this)' value='0' name='customer'>";
    $customerpaginationContents .= "        <span aria-hidden='true'>&laquo;</span>";
    $customerpaginationContents .= "        <span class='sr-only'>Previous</span>";
    $customerpaginationContents .= "      </a>";
    $customerpaginationContents .= "    </li>";
    
  
    $query    = "select 
                  *
                from
                  user_list";

    $result = mysqli_query($db_con, $query);
    $numRow = ceil(mysqli_num_rows($result) / 5) - 1;
    

    if($numRow > 5) {
      for ($i=0; $i < 5; $i++) { 
        $customerpaginationContents .= "<li class='page-item'><a class='page-link' onclick='nextPage(this)' value='$i' name='customer'>" . ($i + 1) . "</a></li>";
      }
    } else {
      for ($i=0; $i <= $numRow; $i++) { 
        $customerpaginationContents .= "<li class='page-item'><a class='page-link' onclick='nextPage(this)' value='$i' name='customer'>" . ($i + 1) . "</a></li>";
      }
    }

    $customerpaginationContents .= "    <li class='page-item'>";
    $customerpaginationContents .= "      <a class='page-link' href='#' aria-label='Next' onclick='nextPage(this)' value='" . $numRow . "' name='customer'>";
    $customerpaginationContents .= "        <span aria-hidden='true'>&raquo;</span>";
    $customerpaginationContents .= "        <span class='sr-only'>Next</span>";
    $customerpaginationContents .= "      </a>";
    $customerpaginationContents .= "    </li>";
    $customerpaginationContents .= "  </ul>";
    $customerpaginationContents .= "</nav>";

    $result = array(
      'productListUp' => $productListUpContents,
      'customerListup' => $customerListUpContents,
      'productPagination' => $productpaginationContents,
      'customerPagination' => $customerpaginationContents
    );
    echo json_encode($result);
    
}





 ?>

