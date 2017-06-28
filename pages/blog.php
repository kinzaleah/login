<?php

$twig = getTwig();






$posts = displayBlogs();


echo $twig->render('blog.twig', ['posts' => $posts, 'loggedIn' => !empty($_SESSION['user'])]);