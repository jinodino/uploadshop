<?php
// echo json_encode($_REQUEST);
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

$function = $_POST["function"];

if($function == "pagination") {
    $page = $_POST["page"];
    $classification = $_POST["classification"];
    
    $standardPage = $page * 5;
    
    if($classification == "product") {
    
        $query    = "select 
              *
            from
              product_list
            order by
              p_num desc
            limit $standardPage, 5";
            
    
        $result   =   mysqli_query($db_con, $query);
    
        $productListUpContents = "";
        while($row  =   mysqli_fetch_array($result)) {
            $productListUpContents .= "<tr data-toggle='modal' data-target='#productModal' onclick='selectInfo(id)'  name='productModal' id='product-" . $row['p_num'] . "'>";
            $productListUpContents .= "    <th scope='row'>" . $row['p_num'] . "</th>";
            $productListUpContents .= "    <td>" . $row['p_name'] . "</td>";
            $productListUpContents .= "    <td>" . $row['p_price'] . "</td>";
            $productListUpContents .= "</tr>";
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

        if($page == 0 || $page == 1) {

            if($numRow > 5) {
              for ($i=0; $i < 5; $i++) { 
                $productpaginationContents .= "<li class='page-item'><a class='page-link' onclick='nextPage(this)' value='$i' name='product'>" . ($i + 1) . "</a></li>";
              }
            } else {
              for ($i=0; $i <= $numRow; $i++) { 
                $productpaginationContents .= "<li class='page-item'><a class='page-link' onclick='nextPage(this)' value='$i' name='product'>" . ($i + 1) . "</a></li>";
              }
            }
        }
          else if($page == $numRow || $page == $numRow - 1) {
              // 5 이하일 경우
              if($numRow < 5) {
                  for ($i=0; $i <= $numRow; $i++) { 
                    $productpaginationContents .= "<li class='page-item'><a class='page-link' onclick='nextPage(this)' value='$i' name='product'>" . ($i + 1) . "</a></li>";
                  }
              } else {
                  for ($i= $numRow - 4; $i <= $numRow; $i++) { 
                    $productpaginationContents .= "<li class='page-item'><a class='page-link' onclick='nextPage(this)' value='$i' name='product'>" . ($i + 1) . "</a></li>";
              }
            }
        } 
          else {
              for ($i= $page - 2; $i <= $page + 2; $i++) { 
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


        $result = array(
          'productListUp'     => $productListUpContents,
          'productPagination' => $productpaginationContents,
        );

        
    
    }
    else if($classification == "customer") {
    
        $query    = "select 
              *
            from
              user_list
            order by
              user_num desc
            limit $standardPage, 5";
    
        $result   =   mysqli_query($db_con, $query);
    
        $customerListUpContents = "";

        while($row  =   mysqli_fetch_array($result)) {
            $customerListUpContents .= "<tr data-toggle='modal' data-target='#customerModal' onclick='selectInfo(id)'  name='customerModal' id='customer-" . $row['user_id'] . "'>";
            $customerListUpContents .= "    <th scope='row'>" . $row['user_num'] . "</th>";
            $customerListUpContents .= "    <td>" . $row['user_id'] . "</td>";
            $customerListUpContents .= "    <td>" . $row['user_name'] . "</td>";
            $customerListUpContents .= "</tr>";
        }
    

        // pagination

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

        // 페이지네이션
        // 1. 선택한 페이지가 좌 우로 -2 +2 값이 있는지?
        // 2-1. 있다 하면 페이지 기준 -2 부터 +2 까지
        // 2-2. 없을 경우 (1, 2 마지막 -1, 마지막) 
        // 3. 기본적으로 값이 5 이하 일 때
        // 4. 기본적으로 값이 5 초과 일 때
        if($page == 0 || $page == 1) {
            if($numRow > 5) {
              for ($i=0; $i < 5; $i++) { 
                $customerpaginationContents .= "<li class='page-item'><a class='page-link' onclick='nextPage(this)' value='$i' name='customer'>" . ($i + 1) . "</a></li>";
              }
            } else {
              for ($i=0; $i <= $numRow; $i++) { 
                $customerpaginationContents .= "<li class='page-item'><a class='page-link' onclick='nextPage(this)' value='$i' name='customer'>" . ($i + 1) . "</a></li>";
              }
            }
        }
        else if($page == $numRow || $page == $numRow - 1) {
            // 5 이하일 경우
            if($numRow < 5) {
                for ($i=0; $i < $numRow; $i++) { 
                  $customerpaginationContents .= "<li class='page-item'><a class='page-link' onclick='nextPage(this)' value='$i' name='customer'>" . ($i + 1) . "</a></li>";
                }
            } else {
                for ($i= $numRow - 4; $i <= $numRow; $i++) { 
                  $customerpaginationContents .= "<li class='page-item'><a class='page-link' onclick='nextPage(this)' value='$i' name='customer'>" . ($i + 1) . "</a></li>";
                }
            }
        } 
        else {
            for ($i= $page - 2; $i <= $page + 2; $i++) { 
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
          'customerListUp'     => $customerListUpContents,
          'customerPagination' => $customerpaginationContents,
        );
    
    }
      
   

    echo json_encode($result);
}

?>