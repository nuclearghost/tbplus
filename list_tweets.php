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

  // Listing tables in your database
  $query = 'SELECT handle,text FROM users, tweets, sends WHERE users.userID = sends.userID AND tweets.tweetID = sends.tweetID';
  $result = mysqli_query($dbcon, $query)
    or die('Show tables failed: ' . mysqli_error());

  //print "The tables in $database database are:<br>";

  // Printing table names in HTML
  // 
  print '<ul>';
  while ($tuple = mysqli_fetch_row($result)) {
  print "<li><b>$tuple[0]</b>: $tuple[1]";
  }
  print '</ul>';

  // Free result
  mysqli_free_result($result);

  // Closing connection
  mysqli_close($dbcon);
?> 
