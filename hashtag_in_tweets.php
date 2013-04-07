<?php

  // Connection parameters 
  $host = 'cspp53001.cs.uchicago.edu';
  $username = 'meyer7';
  $password = '37Mt4bwu11';
  $database = $username.'DB';

  // Attempting to connect 
  $dbcon = mysqli_connect($host, $username, $password, $database)
    or die('Could not connect: ' . mysqli_connect_error());
  //print 'Connected successfully!<br>';

  // Selecting a database
  //   Unnecessary in this case because we have already selected 
  //   the right database with the connect statement.  
  mysqli_select_db($dbcon, $database)
    or die('Could not select database');
  //print 'Selected database successfully!<br>';

  $tag = $_GET["tag"];

  // Listing tables in your database
  $query = "SELECT tweets.text FROM hashTags, tweets, containsTag WHERE tag =\"$tag\" AND hashTags.hashTagID = containsTag.hashTagID AND containsTag.tweetID = tweets.tweetID";
  $result = mysqli_query($dbcon, $query)
    or die('Tweets by user failed: ' . mysqli_error());

  $json = array();
  while ($tuple = mysqli_fetch_row($result)){
    //print $tuple;
    array_push($json, $tuple[0]);
  }

  // Free result
  mysqli_free_result($result);

  // Closing connection
  mysqli_close($dbcon);

  echo json_encode($json);
?> 
