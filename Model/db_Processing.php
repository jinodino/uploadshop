<?php


class DB_info
{
  const DB_URL  = "localhost";
  const DB_HOST = "root";
  const DB_PW   = 'rootroot';
  const DB_NAME = "ecmall";

}


$Query = new mysqli(DB_info::DB_URL, DB_info::DB_HOST,
                    DB_info::DB_PW, DB_info::DB_NAME);



class process{

  

  function insert($table, $value){
    global $Query;
      $Query->query("insert into $table values $value");
  }

  function delete($table, $column, $value){
    global $Query;
      $Query->query("delete from $table where $column = $value");
  }

  function update($table, $numColumn, $nameColumn, $priceColumn, $memoColumn, $imgColumn){
    global $Query;
      $Query->query("update $table SET p_name = '$nameColumn', p_price = $priceColumn, p_memo = '$memoColumn', p_img = '$imgColumn' WHERE p_num = $numColumn");
  }

  function updateNoFileName($table, $numColumn, $nameColumn, $priceColumn, $memoColumn){
    global $Query;
      $Query->query("update $table SET p_name = '$nameColumn', p_price = $priceColumn, p_memo = '$memoColumn' WHERE p_num = $numColumn");
  }
}



 ?>
