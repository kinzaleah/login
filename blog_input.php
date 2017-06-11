<?php

include 'functions.php';

$twig = getTwig();
session_start();


if($_SERVER['REQUEST_METHOD'] == "POST")

{
    $blogTitle = $_POST["title"];
    $blogBody = $_POST["body"];
    $userId = $_SESSION["user_id"];
 
    addBlog($blogTitle, $blogBody, $userId);
}






 

function titleIsEmpty($blogTitle)
{
   //empty blog title
    if (empty($blogTitle)) 
    {
        return "Please enter a title!";
        //return a string of error message
    } else {
    
        return false;
    }
}

function bodyIsEmpty($blogBody)
{
   //empty blog body
    if (empty($blogBody)) 
    {
        return "Please enter your blog!";
        //return a string of error message
    } else {
    
        return false;
    }
}

function addBlog($blogTitle, $blogBody, $userId) 
{
    if (!empty($blogTitle) && !empty($blogBody)) 
    {
        $pdo = getDatabase();
    
        //pdo prepare, bindParam & execute
        //this is inserting the submitted blog title & body into DB if not empty
        $stmt = $pdo->prepare('INSERT INTO blog (title, body, user_id ) VALUES (:title, :body, :user_id)');
        $stmt->bindParam(':title', $blogTitle);
        $stmt->bindParam(':body', $blogBody);
        $stmt->bindParam(':user_id', $userId);
        
        
        
        if ($stmt->execute()) 
        {
            // success
        } else {
            // failure
        }
    }
}


echo $twig->render('blog_input.twig');