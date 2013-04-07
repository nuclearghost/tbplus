<?php

  require 'db_connect.php';

  $handle = $_POST["handle"];
  $password = $_POST["password"];

  //print "Hello $handle.  Is your password $password ? <br />";

  $query = "SELECT * FROM users WHERE handle = \"$handle\"";
  $result = mysqli_query($dbcon, $query)
    or die('Find user failed: ' . mysqli_error());

  if ($result->num_rows != 1)
  {
    mysqli_free_result($result);
    mysqli_close($dbcon);

    $host = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'error.php';
    header("Location: http://$host$uri/$extra");
  }
  else 
  {
    $tuple = mysqli_fetch_row($result);
    if ($password === $tuple[2])
    {
      //print "logged in";
      mysqli_free_result($result);
      session_start();
      $_SESSION['handle'] = $handle;

      $query = "SELECT B.handle FROM users A,users B, follows WHERE A.handle =\"$handle\" AND A.userID = followeeID AND followerID=B.userID";
      $result = mysqli_query($dbcon, $query)
        or die('Tweets by user failed: ' . mysqli_error());

      $json = array();
      while ($tuple = mysqli_fetch_row($result)){
        array_push($json, $tuple[0]);
      }
      $_SESSION['followers'] = $json;

      mysqli_free_result($result);
      
      //print "logged in";
      $query = "SELECT B.handle FROM users A,users B, follows WHERE A.handle =\"$user\" AND A.userID = followerID AND followeeID=B.userID";
      $result = mysqli_query($dbcon, $query)
        or die('Tweets by user failed: ' . mysqli_error());

      $json = array();
      while ($tuple = mysqli_fetch_row($result)){
        array_push($json, $tuple[0]);
      }
      $_SESSION['leaders'] = $json;

      // Free result
      mysqli_free_result($result);
      //print "logged in";
      mysqli_close($dbcon);

      $host = $_SERVER['HTTP_HOST'];
      $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'main.php';
      header("Location: http://$host$uri/$extra");
      //http_redirect("main.php", array(), true);
      //login success
    }
    else
    {
      mysqli_free_result($result);
      mysqli_close($dbcon);

      $host = $_SERVER['HTTP_HOST'];
      $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'error.php';
      header("Location: http://$host$uri/$extra?$password&$tuple[2]");
    }
  }

  //mysqli_close($dbcon);
?>
