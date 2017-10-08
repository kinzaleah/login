<?php

$twig = getTwig();


$urlParts = explode('/', $_SERVER['REQUEST_URI']);

$author = !empty($urlParts[2]) ? $urlParts[2] : null;


$authorsList = getAuthors();

$posts = displayBlogs($author);


echo $twig->render(
    'blog.twig', 
    [
        'posts' => $posts, 
        'loggedIn' => !empty($_SESSION['user']),
        'author' => $author, 
        'authorsList' => $authorsList 
    ]
);