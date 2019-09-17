<?php
include '../Model/db_Processing.php';
error_reporting(0);

$db_con   =   new mysqli(DB_info::DB_URL, DB_info::DB_HOST,
                          DB_info::DB_PW, DB_info::DB_NAME);

$_POST['user_id'];
$_POST['user_name'];
 ?>

 <head>
   <!-- bootstrap CDN Code Import-->
   <!-- Latest compiled and minified CSS -->
   <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
   <!-- jQuery library -->
   <!-- Popper JS -->
   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> -->
   <!-- Latest compiled JavaScript -->
   <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></!--> -->
   <!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> -->

<!-- modal 관련 link -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<style>

    body {
      /* margin: 10px 50px 10px 50px; */
      margin: 0 auto;
      width: 1200px;
    }

    .listup-container {
        margin: 25px 0;
    }
    .left-div {
        float: left;
        width: 50%;
        height: 400px;  
        padding-right: 20px;

    }

    
    .right-div {
        float: left;
        width: 50%; 
        height: 400px;  
        padding-left: 20px;

    }    


    .customer-listup-container-header, .product-listup-container-header {
        font-size: 23px;
        font-weight: bold;
    }

    .product-listup-container-footer, .customer-listup-container-footer {
        padding: 0 160px;
    }   

    /* bootstrap css */
    .pagination {
        margin: 5px 0;
    }

    /* table css */
    .product-table-thead {
        opacity: 0.8;
        background: blanchedalmond;
    }

    .customer-table-thead {
        opacity: 0.8;
        background: whitesmoke;
    }

    .product-listup-container-body {
        height: 285px;
    }

    .customer-listup-container-body {
        height: 285px;
    }

    .product-table-tbody tr:hover {
        background-color: aliceblue;
        font-weight: bold;
    }

    .customer-table-tbody tr:hover {
        background-color: aliceblue;
        font-weight: bold;
    }


    /*　modal  */
    .modal-container {
        margin: 6.75rem auto;
    }

    .modal-header {
        padding: 1rem 1rem 0.5rem 1rem;
    }

    .info-title {
        font-weight: bold;
        font-size  : 15px;
    }
    
    .info-container {
        margin: 5px 0;
    }
    
    .info-id, .info-name, .info-phone{
        font-weight: 600;
    }
    
    .product-img-tag
    {
        margin: 10px 0;
        width: 200px;
        height: 200px;
        max-width: 200px;
        max-height: 200px;
    }

    .change-button-frame {
        display: inline;
    }

    .close-button-frame {
        display: inline;
    }

    .order-info-table thead {
        background-color: mistyrose;
    }

    .order-info-table > thead > tr > th:nth-child(1) {
        min-width: 100px;
    }

    .order-info-table > thead > tr > th:nth-child(2) {
        min-width: 50px;
    }

    .order-info-table > thead > tr > th:nth-child(3) {
        min-width: 300px;
    }

    .order-info-table > thead > tr > th:nth-child(4) {
        max-width: 120px;
    }



</style>
</head>
<body onload="listupInfo()">
  
</body>

<center>
<?php 
  include "./top.php";
?>
</center>

<?php
$query = "select user_num from user_list where user_id= '". $_POST['user_id']."'" ;

$result = mysqli_query($db_con,$query);
$row = mysqli_fetch_array($result);

 ?>
 <?php 
    include "./manager_List.php";
    include "./listModal.php";
?>
<center>
    <hr />
    
    <div id="ordercheck">

        <h3>注文確認欄</h3>
        <table class="table table-striped">

            <thead>
               <tr>
                 <th scope="col">注文番号</th>
                 <th scope="col">注文金額</th>
                 <th scope="col">注文者情報</th>
                 <th scope="col">決済方法</th>
               </tr>
             </thead>

<?php

$Ordercheck_query  = "select * from order_list as a join customer_list as b
                        on a.order_num = b.order_num where a.user_num =".$row['user_num']."" ;

$Ordercheck_result = mysqli_query($db_con, $Ordercheck_query);

while ($Ordercheck_row = mysqli_fetch_array($Ordercheck_result)) {?>

               <tr>
                 <th scope="row"><?=$Ordercheck_row['order_num'] ?></th>
                 <td><?=$Ordercheck_row['p_price'] ?>円</td>
                 <td><?=$Ordercheck_row['customer_name'] ?></td>
                 <td><?=$Ordercheck_row['p_payment'] ?></td>
               </tr>
<?php } ?>

        </table>
    </div>
    <hr />

    <br />
    <hr />



    <div id="cartcheck">

        <h3>CART確認欄</h3>
        <table class="table table-striped">

            <thead>
               <tr>
                 <th scope="col">PRODUCT INFO</th>
                 <th scope="col">PRODUCT NAME</th>
                 <th scope="col">PRODUCT COUNT</th>
               </tr>
             </thead>

    <?php

    $Ordercheck_query  = "select * from cart_list as a join product_list as b
                        on a.p_num = b.p_num where a.user_num =".$row['user_num']." " ;

    $Ordercheck_result = mysqli_query($db_con, $Ordercheck_query);

    while ($Ordercheck_row = mysqli_fetch_array($Ordercheck_result)) {?>

               <tr>
                 <td>
                     <input type="image"
                    src="../Public/img/<?=$Ordercheck_row['p_img'] ?>" style="width:200px; height:200px;"/>
                 </td>
                 <td><?=$Ordercheck_row['p_name'] ?></td>
                 <td><?=$Ordercheck_row['p_count'] ?></td>


<!-- purchase function -->
<td>
    <form id="ProductForm" method="post">
        <input type="hidden" name="p_num" value="<?=$Ordercheck_row['p_num'] ?>"/>
        <input type="hidden" name="p_count" value="<?=$Ordercheck_row['p_count'] ?>"/>
        <input type="hidden" name="user_id" value="<?=$_POST['user_id'] ?>"/>
        <input type="hidden" name="user_num" value="<?=$_POST['user_num'] ?>"/>
        <input type= "image" style="width:200px; height:100px;"
                src="../Public/img/buy.png" onclick="Go_Purchase()">
    </form>
</td>
               </tr>
    <?php } ?>

        </table>
    </div>

</center>

<script>
    function Go_Purchase(){
        $("#ProductForm").attr("action", "./product_Purchase.php");
    }

    function listupInfo(){
        $.ajax({
            url:"../Controller/Controller.php",
            type: "post",
            data: {
                function: "listupInfo",
            },
        }).done(function (data){

            var info = JSON.parse(data);

            $(".product-table-tbody").html(info["productListUp"]);
            $(".customer-table-tbody").html(info["customerListup"]);
            $(".product-listup-container-footer").html(info["productPagination"]);
            $(".customer-listup-container-footer").html(info["customerPagination"]);
        });

    }

    function nextPage(obj) {

        $.ajax({
            url:"../Controller/PaginationController.php",
            type: "post",
            data: {
                function       : "pagination",
                classification : obj.name,
                page           : obj.getAttribute("value"),
            },
        }).done(function (data){
            var info = JSON.parse(data);
            if(obj.name == "product") {
                $(".product-table-tbody").html(info["productListUp"]);
                $(".product-listup-container-footer").html(info["productPagination"]);
            }
            else if (obj.name == "customer") {
                $(".customer-table-tbody").html(info["customerListUp"]);
                $(".customer-listup-container-footer").html(info["customerPagination"]);
            }
        });

    }

function selectInfo(id) {
    var info = id.split('-');
    
    $.ajax({
        url:"../Controller/SelectModalInfo.php",
        type: "post",
        data: {
            id             : info[1],
            classification : info[0]
        },
    }).done(function (data){
        var res = JSON.parse(data);

        if(info[0] == "product") {

            console.log(res);
            $('.product-num-hidden').text(res.p_num);
            $('.product-name').text(res.p_name);
            $('.product-price').text(res.p_price);
            $('.product-memo').text(res.p_memo);
            if(res.p_img != "") {
                $('.product-img-tag').attr("src", "../Public/img/" + res.p_img);
            } else {
                $('.product-img-tag').attr("src", "http://design-ec.com/d/e_others_50/l_e_others_500.png");
            }

        }
        else if(info[0] == "customer") {
        
            // userclass: "Customer"
            $(".info-id").text("・" + res['userInfo'].userId + " (" + res['userInfo'].userclass + ")");
            $(".info-name").text("・" + res['userInfo'].userName);
            $(".info-phone").text("・" + res['userInfo'].userPhone);

            var orderListString = "";

            res['orderInfo'].forEach(element => {
                orderListString += "<tr>";
                element.forEach(list => {
                    orderListString += "<td>" + list + "</td>";
                });
                orderListString += "</tr>";
            });

            $('.customer-order-list').html(orderListString);
        }
    });
}
function changeInfo() {
    var name = $('.product-name').text();
    $('.product-name').html("<input type='text' value=" + name + ">");

    var price = $('.product-price').text();
    $('.product-price').html("<input type='text' value=" + price + ">");

    var memo = $('.product-memo').text();
    $('.product-memo').html("<input type='text' value=" + memo + ">");

    var num = $('.product-num-hidden').text();
    $('.img-change').html("<input type='file' id='filedata' name='uploadfile'>");
    
    $('.change-button-frame').html("<button type='button' class='btn btn-default' onclick='change()'>Change</button>");
}

function change() {
    var formData = new FormData();
    
    var num = $(".product-num-hidden").text();
    var name = $(".product-name input").val(); 
    var price = $(".product-price input").val(); 
    var memo = $(".product-memo input").val();
    var file_data = $("#filedata").prop("files")[0]; 

    formData.append("num", num);
    formData.append("file", file_data);
    formData.append("name", name);
    formData.append("price", price);
    formData.append("memo", memo);

    $.ajax({

        url:"../Controller/ChangeInfoController.php",
        dataType: "text",  
        cache: false,
        contentType: false,
        processData: false,
        type: "post",
        data: formData,

    }).done(function (data){
        $(".product-name").text(name); 
        $(".product-price").text(price); 
        $(".product-memo").text(memo);
        $(".img-change").html(""); 
        $(".product-img-tag").attr("src", data); 
        $('.change-button-frame').html("<button type='button' class='btn btn-default' onclick='changeInfo()'>Change</button>");
    });
}

function closeModal() {
    $(".img-change").html(" ");
    $(".change-button-frame").html("<button type='button' class='btn btn-default' onclick='changeInfo()'>Change</button>");
}

</script>
