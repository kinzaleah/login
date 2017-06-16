<?php

include 'functions.php';
session_start();
$twig = getTwig();

echo $twig->render('logged_in.twig', ['loggedIn' => !empty($_SESSION["user"])]);