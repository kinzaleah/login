<?php


$twig = getTwig();


echo $twig->render('register_success.twig', ['loggedIn' => !empty($_SESSION['user'])]);

?>