<?php

include __DIR__ . '/../functions.php';
require_once __DIR__ . '/../vendor/autoload.php';
use Kinza\Config;

$tokensFile = __DIR__ . '/../data/tokens.json';

//This page is to initially authorise the Spotify user (me) and generate the Spotify code it needs


// spotify session started
$spotifySession = getSpotifySession();

/*

 Spotify needs to generate a code, this checks if there is one already
 If not - it generates one
 If there is then it adds the info to a json file (tokens.json in my data folder)

 */

if (isset($_GET['code'])) {
    $spotifySession->requestAccessToken($_GET['code']);
    $tokens = [
        'access'  => $spotifySession->getAccessToken(),
        'refresh' => $spotifySession->getRefreshToken(),
    ];

    file_put_contents($tokensFile, json_encode($tokens));
} else {
    $options = [
        'scope' => [
            'user-read-email',
        ],
    ];

    header('Location: ' . $spotifySession->getAuthorizeUrl($options));
}