<?php

include __DIR__ .'/../functions.php';
session_start();

$urlParts = explode('/', $_SERVER['REQUEST_URI']);
$pageName = $urlParts[1] ?: 'home';




$filePath = __DIR__ . "/../pages/$pageName.php";

if (file_exists($filePath))
{
    require $filePath;
} else
{
    http_response_code(404);
    echo "404";
}