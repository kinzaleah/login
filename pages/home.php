<?php



$twig = getTwig();





echo $twig->render('home.twig', ["loggedIn" => !empty($_SESSION['user'])]);