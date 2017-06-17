<?php

include 'functions.php';
$twig = getTwig();

session_start();

unset($_SESSION['user']);


echo $twig->render('logged_out.twig', ['loggedIn' => !empty($_SESSION['user'])]);