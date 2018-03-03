<?php

// __DIR__ is a magic constant that gives you the directory of the current file
require __DIR__ .'/../functions.php';
require __DIR__ .'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider, [
    'twig.path' => __DIR__.'/../view',
]);
$app['debug'] = true;

$app['db'] = function () {
    return getDatabase();
};

$app->get('/', function () use ($app) {
    return $app['twig']->render('home.twig', ["loggedIn" => !empty($_SESSION['user'])]);
});

$app->get( '/blog/{author}', function ($author) use ($app) {

    $authorsList = getAuthors();
    $posts = displayBlogPosts($author);

    return $app['twig']->render(
        'blog.twig',
        [
            'posts' => $posts,
            'loggedIn' => !empty($_SESSION['user']),
            'author' => $author,
            'authorsList' => $authorsList
        ]
    );
});

$app->get( '/blog', function () use ($app) {
    $authorsList = getAuthors();
    $posts = displayBlogPosts();

    return $app['twig']->render(
        'blog.twig',
        [
            'posts' => $posts,
            'loggedIn' => !empty($_SESSION['user']),
            'author' => null,
            'authorsList' => $authorsList
        ]
    );
});

$app->run();

session_start();

$urlParts = parse_url($_SERVER['REQUEST_URI']);

$urlPath = explode('/', $urlParts['path']);

//if $urlParts[1] is truthy use it, otherwise use 'home'
$pageName = $urlPath[1] ?: 'home';




$filePath = __DIR__ . "/../pages/$pageName.php";

if (file_exists($filePath))
{
    require $filePath;
} else
{
    //errpr 
    http_response_code(404);
    echo "404";
}