<?php

include 'functions.php';
session_start();

$twig = getTwig();





echo $twig->render('index.twig', ["loggedIn" => !empty($_SESSION['user'])]);