<?php



$twig = getTwig();





if(!empty($_SESSION['user']))
{
 header('Location: /logged_in');
}




if($_SERVER['REQUEST_METHOD']== "POST") 
{
 
 $user = checkCredentials($_POST['username'], $_POST['password']);
 if ($user !== false) 
 {
   
   $_SESSION['user'] = $user;
   
   header('Location: /logged_in');
 }
  
}

echo $twig->render('login.twig', ['loggedIn' => !empty($_SESSION['user'])]);



?>

