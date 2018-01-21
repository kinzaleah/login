<?php

use Kinza\Config;

$twig = getTwig();
$spotifySession = getSpotifySession();

$tokensFile = __DIR__ . '/../data/tokens.json';

/*

This is my actual Spotify page. It updates the json file with a new access and refresh token
(as it expires after an hour).

 */

$tokens = json_decode(file_get_contents($tokensFile));

//$spotifySession->refreshAccessToken($tokens->refresh);
//
//$tokens = (object) [
//    'access'  => $spotifySession->getAccessToken(),
//    'refresh' => $spotifySession->getRefreshToken(),
//];
//
//file_put_contents($tokensFile, json_encode($tokens));


$api = new SpotifyWebAPI\SpotifyWebAPI();


$api->setAccessToken($tokens->access);

$playlist = $api->getUserPlaylist('rosspeacey', '0NzjNqjJGzhOfUM4cET8BR');
//$playlistTracks = $api->getUserPlaylistTracks('rosspeacey', '0NzjNqjJGzhOfUM4cET8BR');

//var_dump($playlistTracks);



// Need info here for what to pass through to twig to render - any arrays or variables?
echo $twig->render(
    'spotify.twig',
    [
        'spotifyData'       => $api->me(),
        'playlist'          => $playlist,
        'playlistTracks'          => $playlist->tracks->items,
        'loggedIn'          => !empty($_SESSION['user']),
    ]
);