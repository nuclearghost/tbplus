<?php

  require 'db_connect.php';

  $leader = $_GET["leader"];
  $follower = $_GET["follower"];

  $query = "SELECT userID FROM users WHERE handle='$leader'";
  $result = mysqli_query($dbcon, $query)
    or die('Find user failed: ' . mysqli_error($dbcon));


  $temp =  mysqli_fetch_row($result);
  $leaderID = $temp[0];

  $query = "SELECT userID FROM users WHERE handle='$follower'";
  $result = mysqli_query($dbcon, $query)
    or die('Find user failed: ' . mysqli_error($dbcon));

  $temp =  mysqli_fetch_row($result);
  $followerID = $temp[0];

  $query = "INSERT INTO follows (followerID, followeeID) VALUES ($followerID, $leaderID)";
  $result = mysqli_query($dbcon, $query)
    or die('Find user failed: ' . mysqli_error($dbcon));

  $json = $result;

  //mysqli_free_result($result);
  mysqli_close($dbcon);

  echo json_encode($json);
?>
