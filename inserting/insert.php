<?php

set_time_limit(0);

$connection = mysqli_connect("localhost", "root", "cactus001!!") or die("error_1");
mysqli_select_db($connection, "inserting") or die("error_2");

$hashes = array();
$result = mysqli_query($connection,"SELECT hash_code FROM baza ") or die ('error_r');
while($row = mysqli_fetch_array($result)) {
  $hashes[] = $row['hash_code'];
}



function generate_random_string() {

  /*$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, strlen($characters) - 1)];

  }
  return $randomString;*/

  $bytes = random_bytes(150);
  return md5($bytes.microtime().'simral_muellim');
}


$begin = new DateTime( '1950-01-01' );
$end = new DateTime( '2017-01-01' );

$checkdate = mysqli_query($connection, "SELECT count(id) as qtt, date_add FROM baza WHERE date_add = (SELECT date_add FROM baza order by date_add desc limit 1) group by date_add");
$temp = mysqli_fetch_array($checkdate);
$counter = 1000 - $temp['qtt'];

if(isset($temp['date_add']) && $temp['date_add'] > $begin) {

	$begin = $temp['date_add'];
	if($counter == 0) {

		$begin = strtotime($begin, "+ 1 day");
	}
}


// echo $begin->format('Y-m-d');
// unset($hashes);
// exit;

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);


$sql_arr = array();

foreach ( $period as $dt ) {

  $date_add = $dt->format('Y-m-d');

  $counter = 0;

  

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
    $sql_arr[] = "('".$hash."', '".$date_add."', '".$number."')";


    //echo $counter, "<br/>";

  }  while ($counter <= 999);



  //print_r($sql_arr);

  if(sizeof($sql_arr) == 1000) {
    $tmp = JOIN(",", $sql_arr);
    mysqli_query($connection, "INSERT INTO baza(hash_code, date_add, price) VALUES ".$tmp."  ") or die('mysqli_error(connection)');
    $sql_arr = array();
    echo "1000+";
  }

}



mysqli_close($connection);




?>
