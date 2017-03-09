<?php

set_time_limit(0);

$connection = mysqli_connect("localhost", "root", "cactus001!!") or die("error_1");
mysqli_select_db($connection, "inserting") or die("error_2");

$hashes = array();
$result = mysqli_query($connection,"SELECT hash_code FROM baza ") or die ('error_r');
while($row = mysqli_fetch_array($result)) {
  //$hashes[] = $row['hash_code'];
}



function generate_random_string() {


  $bytes = random_bytes(550);
  return md5($bytes.microtime().'simral_muellim');
}

$begin = strtotime('1950-01-01');
$end = time();


$checkdate = mysqli_query($connection, "SELECT count(id) as qtt, date_add FROM baza WHERE date_add = (SELECT date_add FROM baza order by date_add desc limit 1) group by date_add");
$temp = mysqli_fetch_array($checkdate);
$counter = 1000 - $temp['qtt'];




if(isset($temp['date_add']) && $temp['date_add'] != '') {
	if($counter == 0) {
		$begin = strtotime("+1 day", strtotime($temp['date_add']));
	}
}


$sql_arr = array();

$counter = 0;

do {



  do {
    $counter++;
    $isUnique = false;

    do {

      $hash = generate_random_string();
      if(!in_array($hash, $hashes)) {
          $isUnique = true;

      }
    } while (!$isUnique);



    $number =  mt_rand(0, 999);
    $sql_arr[] = "('".$hash."', '".date("Y-m-d", $begin)."', '".$number."')";


    //echo $counter, "<br/>";

  }  while ($counter <= 999);



//   print_r($sql_arr);
// exit;
  if(sizeof($sql_arr) == 100000) {

    $tmp = JOIN(",", $sql_arr);

    mysqli_query($connection, "INSERT INTO baza(hash_code, date_add, price) VALUES ".$tmp."  ") or die('mysqli_error(connection)');
    $sql_arr = array();

    echo "100000+";
  }

} while ((time() - $begin) > 86400);



mysqli_close($connection);




?>
