<?php

include 'functions.php';


$twig = getTwig();
session_start();

if(empty($_SESSION['user'])) 
{
   header('Location: /login.php'); 
    
}


if($_SERVER['REQUEST_METHOD'] == "POST")

{
    $blogTitle = $_POST["title"];
    $blogBody = $_POST["body"];
    $userId = $_SESSION["user"]->id;
 
    addBlog($blogTitle, $blogBody, $userId);
}






 




echo $twig->render('blog_input.twig', ["loggedIn" => !empty($_SESSION['user'])]);