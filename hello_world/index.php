
<?php


if(isset($_POST['submit'])); {
$message = $_POST['message'];

  $pieces = explode(" ", $message);

  $str = '';
  foreach($pieces as $message) {
      $p1 = mb_substr($message, 0,1);
      $p2 = mb_substr($message, 1, mb_strlen($message)-2);
      $p3 = mb_substr($message, -1);

      $str .= $p3.$p2.$p1."\n";

  // echo $str, "<br />";
  }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>test</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="./style.css">
  </head>
  <body>
    <div class="main">
      <form id="form"   class="form row" name="form" method="POST">
        <div class="form-group col-md-12">
            <textarea name="message" class="form-control" rows="8"
            ><?=$str;?></textarea>
          </div>
          <div class="form-group col-md-12">
                <input type="submit"  name="submit" class="button" value="Submit">
            </div>
        </form>
      </div>
  </body>
</html>
