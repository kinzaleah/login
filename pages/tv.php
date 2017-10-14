<?php

$twig = getTwig();

//run the addShow function if someone posts & convert input to lower case
if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $title = strtolower($_POST["title"]);
        $genre = strtolower($_POST["genre"]);
        $season = $_POST["season"];
        $platform = strtolower($_POST["platform"]);
        $notes = strtolower($_POST["notes"]);
        
        addShow($title, $genre, $season, $platform, $notes);
    }



echo $twig->render('tv.twig', ['loggedIn' => !empty($_SESSION["user"])]);