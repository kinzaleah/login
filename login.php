<?php

include 'functions.php';

$twig = getTwig();



session_start();

if(!empty($_SESSION['user_id']))
{
 header('Location: /logged_in.php');
}




if($_SERVER['REQUEST_METHOD']== "POST") 
{
 
 $user = checkCredentials($_POST['username'], $_POST['password']);
 if ($user !== false) 
 {
   $_SESSION['user_id'] = $user["user_id"];
   header('Location: /logged_in.php');
 }
  
}

echo $twig->render('login.twig');



?>

