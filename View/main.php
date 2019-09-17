<?php

include '../Model/db_Processing.php';
error_reporting(0);
session_start();


$db_con   =   new mysqli(DB_info::DB_URL, DB_info::DB_HOST,
                          DB_info::DB_PW, DB_info::DB_NAME);

?>

<!-- included CDN and css information -->
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <meta charset="utf-8">


  <!-- bootstrap CDN Code Import-->
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- JQuery library -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


  <!-- Link Swiper's CSS -->
  <link rel="stylesheet" href="../Public/css/swiper.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.x.x/css/swiper.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.x.x/css/swiper.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.x.x/js/swiper.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.x.x/js/swiper.min.js"></script>
  <link rel="stylesheet" href="../Public/css/main.min.css">
</head>

<body onload="popularProduct()">
<center>

<?php 
  include "./top.php";
?>



  <!-- Insert Image Swiper -->
  <div class="swiper-container">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <image src="../Public/img/1.jpg" style="width: 700px; height=700px;">
      </div>
      <div class="swiper-slide">
        <image src="../Public/img/3.PNG" style="width: 700px; height=700px;">
      </div>
      <div class="swiper-slide">
        <image src="../Public/img/4.PNG" style="width: 700px; height=700px;">
      </div>
      <div class="swiper-slide">
        <image src="../Public/img/10.PNG" style="width: 700px; height=700px;">
      </div>
      <div class="swiper-slide">
        <image src="../Public/img/6.PNG" style="width: 700px; height=700px;">
      </div>
    </div>


    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
  </div>

  <!-- Swiper JS Import -->
  <script src="../Public/js/swiper.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper('.swiper-container', {
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
        renderBullet: function(index, className) {
          return '<span class="' + className + '">' + (index + 1) + '</span>';
        },
      },
    });
  </script>



  <!-- Category Bar -->
  <nav role="navigation" class="nav">
    <ul id="main-menu">
      <li><a href="#">Post it</a>
        <ul id="sub-menu">
          <li><a href="#" aria-label="subemnu">Grid</a></li>
        </ul>
      </li>

      <li><a href="#">Note and MemoPad</a>
        <ul id="sub-menu">
          <li><a href="#" aria-label="subemnu">Grid Note</a></li>
        </ul>
      </li>

      <li><a href="#">Sticker and Pen</a>
        <ul id="sub-menu">
          <li><a href="#" aria-label="subemnu">Sticker</a></li>
          <li><a href="#" aria-label="subemnu">Meomory Sticker</a></li>
          <li><a href="#" aria-label="subemnu">Pen</a></li>
        </ul>
      </li>


<!-- Set different categories that are visible according to user permissions -->
<!-- Display product registration category if user == administrator -->
    <?php
        if($_SESSION['user_qualify'] == "2"){?>
            <li><a onclick="product_Register()">Product Register</a></li>
    <?php } ?>


<li>
<a style="padding-bottom:0px; padding-top:10px;">
<form action="./product_List.php" method="post" id = "session_submit" style="margin:0px;">

   <input type="hidden" name="user_id" value="<?php echo  $_SESSION['user_id']; ?>"/>
  <input type="hidden" name="user_name" value="<?php echo   $_SESSION['user_name']; ?>"/>
  <input type="submit" class="btn btn-link" style="color:white;"
  name="Submit1" value="Product List" onclick="product_List()"/>
</form>

</a>
</li>

</nav>


<!-- Display Recommend Product List/Cart/Purchase Buttons -->
<!-- Query Process that Call Product Information from Database -->
<?php
$query    =   "select * from product_list where p_num=9";
$result   =   mysqli_query($db_con,$query);
$row      =   mysqli_fetch_array($result);

$user_num_query = "select user_num from user_list where user_id = '". $_SESSION['user_id']."'" ;
$user_num_result = mysqli_query($db_con,$user_num_query);
$user_num_row = mysqli_fetch_array($user_num_result);
 ?>

<!-- 商品個別divを包むdiv -->
<Br />
  <h2>Recommend Product</h2>

  <!-- Product div -->
<div class="row">


</div>



<BR /><BR /><BR />
<HR />

<BR />
<footer id = "footer">
    <p>Contact Mail
    <a href="mailto:jeongjm0501@gmail.com"><span class="glyphicon glyphicon-envelope"></span></a>
  </p>

</footer>
<div class="test"  hidden name="function" value="test"></div>
<BR />

</center>

<script>
    function ajax(){
        $.ajax({
          url:"../Controller/Controller.php",
          type: "post",
          data:$("form").serialize()
        }).done(function (data){
          $("#loginResult").append(data);
        });
    }

    function popularProduct(){
        $.ajax({
            url:"../Controller/Controller.php",
            type: "post",
            data: {function: "popularProduct"},
        }).done(function (data){
            $(".row").html(data);
        });
    }


    function user_Join(){
      window.open("./user_Join.php","user register", "width:250px, height:250px");
    }


    function Go_Cart(){
        $(".Speed_Purchasing").attr("action", "../Controller/product_Cart.php");

    }


    function Go_Purchase(){
        $(".Speed_Purchasing").attr("action", "./product_Purchase.php");
    }



    function product_Register(){
      window.open("./product_Register.php", "width:250px, height:250px");
    }

    function product_List(){
        window.onload = function(){
                          document.session_submit.Submit1.click();
                  }
      }


</script>
