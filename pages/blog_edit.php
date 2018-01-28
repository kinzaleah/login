<?php

$twig = getTwig();

$blogId = $_REQUEST['id'];
$blogPost = getSingleBlogPost($blogId);

/** @var \Kinza\User $user */
$user = $_SESSION["user"];

if ($blogPost['author'] !== $user->username) {
    http_response_code(403);
    die;
}

if($_SERVER['REQUEST_METHOD'] === "POST"){
    updateBlogPost($_POST['id'], $_POST['title'], $_POST['body']);
}

$blogPost = getSingleBlogPost($blogId);

echo $twig->render('blog_edit.twig', ["blogPost" => $blogPost, 'loggedIn' => !empty($_SESSION["user"])]);