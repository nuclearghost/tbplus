<?php

  require 'db_connect.php';

  $handle = $_GET["handle"];
  /*
  $limit  = $_GET["limit"];
  $timestamp = $_GET["timestamp"];
   */

  $query = "SELECT B.handle, text, sendTime FROM users A, users B, follows, tweets, sends WHERE A.userID = followerID AND B.userID = followeeID AND B.userID = sends.userID AND sends.tweetID = tweets.tweetID AND A.handle = \"$handle\" ORDER BY sendTime DESC";
  $result = mysqli_query($dbcon, $query)
    or die('Find user failed: ' . mysqli_error());

    $json = array();
    while ($tuple = mysqli_fetch_row($result)){
      array_push($json, $tuple);
    }

    mysqli_free_result($result);
    mysqli_close($dbcon);

    echo json_encode($json);
?>
