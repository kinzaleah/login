<?php


use Kinza\Config;
$twig = getTwig();
//curl stuff to use the API and return the json resource
//haven't put access token in here, it's in Config so git can ignore

$ch = curl_init('https://api.instagram.com/v1/users/self/media/recent/?access_token='.Config::INSTAGRAM_ACCESS_TOKEN);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

//this converts the json into an array so we can access bits of it

$decodedResponse = json_decode($response);

// var_dump($deecodedResponse->data[0]->images->standard_resolution->url);

//foreach here to go through each img array and display the standard res pic & caption

// foreach($decodedResponse->data as $img) {
    
//     echo <<<eot
//     <img src="{$img->images->standard_resolution->url}">
//     <p> {$img->caption->text} </p>
//     <p> {$img->likes->count} likes </p>
    
// eot;
// }





echo $twig->render('instagram.twig', ['images' => $decodedResponse->data, 'loggedIn' => !empty($_SESSION['user'])]);

