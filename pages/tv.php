<?php

$twig = getTwig();

//run the addShow function if someone posts & convert input to lower case
if($_SERVER['REQUEST_METHOD'] == "POST")
   
   //check if fields are empty/invalid first 
{
    $titleIsValid = titleIsValid($_POST["title"]);
    $genreIsValid = genreIsValid($_POST["genre"]);
    $seasonIsValid = seasonIsValid($_POST["season"]);
    $platformIsValid = platformIsValid($_POST["platform"]);

    
    if($titleIsValid === true 
      && $genreIsValid === true 
      && $seasonIsValid === true
      && $platformIsValid === true) {
         //convert input to lower case before writing to db (except season as it's a number)
        $title = strtolower($_POST["title"]);
        $genre = strtolower($_POST["genre"]);
        $season = $_POST["season"];
        $platform = strtolower($_POST["platform"]);
        $notes = $_POST["notes"];
        
        
        
        //then call function that adds innput to DB
        addShow($title, $genre, $season, $platform, $notes);
        
        
    }
}
    
    
    
//error messages are kept in this array (the result of each ...IsValid function)
//which we will pass through to twig then display if an error

$errorMessages = [];

if ($titleIsValid !== true) 
{
    $errorMessages['title'] = $titleIsValid;
   
}

if ($genreIsValid !== true) 
{
    $errorMessages['genre'] = $genreIsValid;
}

if ($seasonIsValid !== true) 
{
    $errorMessages['season'] = $seasonIsValid;
}

if ($platformIsValid !== true) 
{
    $errorMessages['platform'] = $platformIsValid;
}

echo $twig->render('tv.twig', ['errorMessages' => $errorMessages, 'loggedIn' => !empty($_SESSION["user"])]);