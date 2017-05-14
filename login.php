<?php

include 'functions.php';

session_start();

if($_SERVER['REQUEST_METHOD']== "POST") 
{
 if (checkCredentials($_POST['username'], $_POST['password'])) 
 {
   $_SESSION['loggedIn'] = true;
   header('Location: /logged_in.php');
 }
  
}





?>
<!DOCTYPE html>

<html>
    <head>
    <title>My first PHP Website</title>
    </head>

    <body>

      <h2>Login Page</h2>

      <a href ="index.php">Click here to go back</a>

      <form action="login.php" method="POST">
        <p>Username: <input type="text" name="username" required ="required" /></p>
        <p>Password: <input type="password" name="password" required ="required" /></p>
        <p><input type="submit" value="Log In" /></p>

      </form>


    </body>


</html>
