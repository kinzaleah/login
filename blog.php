<?php

include 'functions.php';
session_start();

$twig = getTwig();






$posts = displayBlogs();


echo $twig->render('blog.twig', ['posts' => $posts, 'loggedIn' => !empty($_SESSION['user'])]);