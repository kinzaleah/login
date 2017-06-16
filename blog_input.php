<?php

include 'functions.php';

$twig = getTwig();
session_start();


if($_SERVER['REQUEST_METHOD'] == "POST")

{
    $blogTitle = $_POST["title"];
    $blogBody = $_POST["body"];
    $userId = $_SESSION["user"]->id;
 
    addBlog($blogTitle, $blogBody, $userId);
}






 




echo $twig->render('blog_input.twig');