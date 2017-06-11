<?php

include 'functions.php';
$twig = getTwig();

session_start();



session_destroy();

echo $twig->render('logged_out.twig');