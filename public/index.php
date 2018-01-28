<?php

// __DIR__ is a magic constant that gives you the directory of the current file
require __DIR__ .'/../functions.php';


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