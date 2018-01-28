<?php

$twig = getTwig();

$blogPost = getSingleBlogPost($_GET['id']);
/** @var \Kinza\User $user */
$user = $_SESSION["user"];
$userCanEdit = $blogPost['author'] === $user->username;

echo $twig->render(
    'blog_post.twig',
    [
        'blogPost' => $blogPost,
        'loggedIn' => !empty($_SESSION["user"]),
        'userCanEdit' => $userCanEdit,
    ]
);