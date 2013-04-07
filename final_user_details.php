<?php

  // Connection parameters 
  $host = 'cspp53001.cs.uchicago.edu';
  $username = 'meyer7';
  $password = '37Mt4bwu11';
  $database = $username.'DB';

  // Attempting to connect 
  $dbcon = mysqli_connect($host, $username, $password, $database)
    or die('Could not connect: ' . mysqli_connect_error());

  // Selecting a database
  //   Unnecessary in this case because we have already selected 
  //   the right database with the connect statement.  
  mysqli_select_db($dbcon, $database)
    or die('Could not select database');

  $user = $_GET["user"];
  $current_user = $_GET["current_user"];

  $query = "SELECT handle, name, email, accountCreate, following, followers FROM users WHERE handle='$user'";
  $result = mysqli_query($dbcon, $query) or die ('user deets fail'.mysqli_error(dbcon));
  $deets = mysqli_fetch_row($result);

  $query = "SELECT text, sendTime FROM users, sends, tweets WHERE users.userID = sends.userID AND sends.tweetID = tweets.tweetID AND users.handle = '$user' ORDER BY sendTime DESC LIMIT 3";
  $result = mysqli_query($dbcon, $query)
    or die('Describe user failed: ' . mysqli_error($dbcon));

  $json = array();
  while ($tuple = mysqli_fetch_row($result)){
    array_push($json, $tuple);
  }

  // Free result
  mysqli_free_result($result);

  $query = "SELECT * from users A, users B, follows WHERE A.handle = '$current_user' AND A.userID = followeeID AND B.userID = followerID AND B.handle = '$user'"; 
  $result = mysqli_query($dbcon, $query) or die ('Follow lookup failed: '. mysqli_error($dbcon)); 

  if ($result->num_rows == 1)
  {
    $follows = true;
  }
  else
  {
    $follows = false;
  }

  mysqli_free_result($result);

  $query = "SELECT * from users A, users B, follows WHERE A.handle = '$current_user' AND A.userID = followerID AND B.userID = followeeID AND B.handle = '$user'"; 
  $result = mysqli_query($dbcon, $query) or die ('Follow lookup failed: '. mysqli_error()); 

  if ($result->num_rows == 1)
  {
    $following = true;
  }
  else
  {
    $following = false;
  }

  mysqli_free_result($result);
  // Closing connection
  mysqli_close($dbcon);

  $finalJson = array (
    "details" => $deets,
    "tweets" => $json,
    "follows" => $follows,
    "following" => $following
  );

  echo json_encode($finalJson);
?> 

