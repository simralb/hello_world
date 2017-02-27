<?php

$connection = mysqli_connect("localhost", "root", "cactus001!!") or die('err1'); // Establishing Connection with Server

mysqli_select_db($connection, "message") or die('err2'); // Selecting Database from Server

if(isset($_POST['submit'])) { // Fetching variables of the form which travels in URL

  $f_name = $_POST['f_name'];
  $l_name = $_POST['l_name'];
  $u_email = $_POST['u_email'];
  $address = $_POST['address'];
  $message = $_POST['message'];
  $ip = gethostbyname($_SERVER['REMOTE_ADDR']);

  if($f_name !='' || $u_email !='') {

    mysqli_query($connection,
    "INSERT INTO letters(first_name, last_name, email, address, message, ip)
      VALUES ('".$f_name."', '".$l_name."', '".$u_email."', '".$address."', '".$message."', '".$ip."')")
       or die("error4");

    header("Location: thankyou.html");

  } else {
    header("Location: error.html");
  }
}
  mysqli_close($connection);

  if(isset($_POST['submit'])) {
  	$to = 'bagirov.simral@gmail.com';
    $ip = gethostbyname($_SERVER['REMOTE_ADDR']);
  	$f_name  = $_POST['f_name'];
  	$l_name  = $_POST['l_name'];
  	$email   = $_POST['u_email'];
  	$address = $_POST['address'];
  	$subject = "Message from: {$f_name}";
  	$message = "ip:     " . $ip . "\n" .  "Ad:      " . $f_name . "\n" . "Soyad:  " . $l_name . "\n" . "Email:   " . $email . "\n" . "Ünvan:  " . $address . "\n" . "Mesaj:   " . $_POST['message'];

  	$headers="From: {$email}\r\nReply-To: {$email}";
  	mail($to,$subject,$message,$headers);
  	header("Location: thankyou.html");
  	}



?>
