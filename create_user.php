<?php

  require 'db_connect.php';

  $handle = $_POST["handle"];
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  //print "Hello $handle.  Is your password $password ? <br />";

  $query = "SELECT * FROM users WHERE handle = \"$handle\"";
  $result = mysqli_query($dbcon, $query)
    or die('Find user failed: ' . mysqli_error());

  if ($result->num_rows != 0)
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
    $query = "INSERT INTO users (handle, password, name, email) VALUES ('$handle', '$password', '$name', '$email')";
    $result = mysqli_query($dbcon, $query)
      or die('Find user failed: ' . mysqli_error());
    if($result == true)
    {
      session_start();
      $_SESSION['handle'] = $handle;

      $query = "SELECT userID FROM users WHERE handle = '$handle'";
      $result = mysqli_query($dbcon, $query)
        or die('Find user failed: ' . mysqli_error($dbcon));
      $temp = mysqli_fetch_row($result);
      $newID = $temp[0];

      $query = "INSERT INTO follows (followerID, followeeID) VALUES ($newID, 36473)";
      //36473 is the userID for info which is automatically followed by new users to explain functionality
      $result = mysqli_query($dbcon, $query)
        or die('Find user failed: ' . mysqli_error($dbcon));

      $host = $_SERVER['HTTP_HOST'];
      $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'main.php';
      header("Location: http://$host$uri/$extra");
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
