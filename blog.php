<?php

include 'functions.php';

$twig = getTwig();






$posts = displayBlogs();


echo $twig->render('blog.twig', ['posts' => $posts]);