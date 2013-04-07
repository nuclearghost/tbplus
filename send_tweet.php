<?php

  require 'db_connect.php';

  $handle = $_GET["user"];
  $text = $_GET["text"];

  $query = "CALL sendTweet(\"$handle\", \"$text\")";
  $result = mysqli_query($dbcon, $query)
    or die('Find user failed: ' . mysqli_error());

  $json = array( "result" => $result);

  //mysqli_free_result($result);
  mysqli_close($dbcon);

  echo json_encode($json);
?>
