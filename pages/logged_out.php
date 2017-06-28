<?php


$twig = getTwig();



unset($_SESSION['user']);


echo $twig->render('logged_out.twig', ['loggedIn' => !empty($_SESSION['user'])]);