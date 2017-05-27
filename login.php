<?php

include 'functions.php';

$twig = getTwig();



session_start();

if($_SERVER['REQUEST_METHOD']== "POST") 
{
 if (checkCredentials($_POST['username'], $_POST['password'])) 
 {
   $_SESSION['loggedIn'] = true;
   header('Location: /logged_in.php');
 }
  
}

echo $twig->render('login.twig');



?>

