<?php
include '../Model/db_Processing.php';
?>
<head>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- JQuery library -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


</head>
  <body>
  <form action="../Controller/productRegistController.php" method="post" enctype="multipart/form-data" onsubmit="return validateCheck();">

      <div class="product-regist-container">


          <div class="product-regist-header">
              <div class="product-regist-header-title">
                  Product Register -for admin- 
              </div>
          </div>

          <div class="product-reigst-body">
              <div class="line"></div>

              <div class="product-component-container">
                  <div class="product-component-left">
                      <div class="product-component-name">
                          商品名
                      </div>
                  </div>
                  <div class="product-component-right">
                      <div class="product-component-input">
                          <input type="text" class="p_name" name="p_name" size="30"/>
                      </div>
                  </div>
              </div>

              <div class="product-component-container">
                  <div class="product-component-left">
                      <div class="product-component-name">
                          商品価格
                      </div>
                  </div>
                  <div class="product-component-right">
                      <div class="product-component-input">
                          <input type="text" class="p_price" name="p_price" onkeydown="confirmPriceTypeOfNumber(this.value)"  size="30"/>
                          <div class="input-type-not-number">
                          
                          </div>
                      </div>
                  </div>
              </div>

              <div class="product-component-container">
                  <div class="product-component-left">
                      <div class="product-component-name">
                          イメージ
                      </div>
                  </div>
                  <div class="product-component-right">
                      <div class="product-component-input">
                          <div class="input-file">
                            <input type="file" class="p_img" name="p_img" >
                          </div>
                      </div>
                  </div>
              </div>

              <div class="product-component-container">
                  <div class="product-component-left">
                      <div class="product-component-name">

                      </div>
                  </div>
                  <div class="product-component-right">
                      <div class="product-component-input">
                          <div class="img-area">
                              <img src="" alt="" id="imgInp">
                          </div>
                      </div>
                  </div>
              </div>

              <div class="product-component-container">
                  <div class="product-component-left">
                      <div class="product-component-name">
                          メモ
                      </div>
                  </div>
                  <div class="product-component-right">
                      <div class="product-component-input">
                          <textarea name="p_memo"></textarea>
                      </div>
                  </div>
              </div>

          </div>

          <div class="product-regist-footer">
              <input type="submit" value="Register"/>
              <input type="button" onclick="goMainPage()" value="戻る"/>
          </div>
      </div>
  </form>
  </body>
</html>


<style>
body {
  width: 900px;
  margin: 0 auto;
}

.line {
    width: 100%;
    height: 20px;
    background-color: cornsilk;
    /* margin-left: 40px; */
}

.product-regist-header-title {
    font-size: 40px;
    font-weight: bold;
    text-align: center;
    margin: 30px 0;
}

.product-component-container {
    margin: 20px 0 20px 40px;
    display: flex;
    text-align: left;
}

.product-component-left {
    flex: 0.5;
    padding: 10px 0;
}

.product-component-right {
    flex: 2.5;
    padding: 10px 20px;

}


.product-component-name {
    font-size: 20px;
}

.product-component-input input {
    width: 100%;
    height: 30px;
  　border-bottom:1 solid #000000; 
    border-top:0; 
    border-right:0; 
    border-left:0; 
}

.product-component-input textarea{
    width: 100%;
    height: 80px;
}

.input-file {
  width: 250px;
}

.img-area {
 
}

.img-area img{
    max-width: 180px;
    max-height: 180px;
}

.product-regist-footer {
  text-align: center;
}

.product-regist-footer input{
    margin: 10px;
    width: 100px;
    height: 30px;
}

.input-type-not-number {
    font-size: 10px;
    font-weight: 700;
    color: red;
    margin: 5px 0;  
}
</style>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imgInp').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".p_img").change(function() {
        readURL(this);
    });

    function goMainPage() {
        window.location.replace("./main.php");
    }

    function validateCheck() {

        var name  = $(".p_name").val();

        if(!name) { alert("商品名を入力してください"); return false; }

        var price = Number($(".p_price").val());

        if(price == "numberNaN") { alert("商品価格は数字だけ入力してください。"); return false; }

        if(!price) { alert("商品価格を入力してください"); return false; }

        return true;
    }


    function confirmPriceTypeOfNumber(x) {
        // 입력값이 숫자가 아니면 공백
        var regex= /[0-9]/g

        if(regex.test(x)) {
            $(".input-type-not-number").text("");
            return; 
        }
        

        $(".input-type-not-number").text("数字を入力ください");
    }
</script>