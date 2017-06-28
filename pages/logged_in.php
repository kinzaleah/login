<?php


$twig = getTwig();

echo $twig->render('logged_in.twig', ['loggedIn' => !empty($_SESSION["user"])]);