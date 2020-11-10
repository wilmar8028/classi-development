<?php

echo '
<html>
<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
';

if ( isset($_COOKIE['theme']) ) {

    if ( $_COOKIE['theme'] == 'Light Theme' ) {
          echo '
            <style>
                body {
                    font-family: Comfortaa;
                }
            </style>
          ';
        }

    if ( $_COOKIE['theme'] == 'Dark Theme' ) {
          echo '
            <style>
                body {
                    font-family: Comfortaa;
                    background-color: #121212;
                    color: #cccccc;
                }

                a {
                    color: #cccccc;
                    text-decoration: none;
                }
            </style>
          ';
        }

    if ( $_COOKIE['theme'] == 'Da Lincoln Theme' ) {
          echo '
            <style>
                body {
                    font-family: Comfortaa;
                    background-color: #121212;
                    color: #ffa500;
                }

                a {
                    color: #ffa500;
                    text-decoration: none;
                }
            </style>
          ';
        }

}

echo '<body>';

echo '<center><h1 style="font-size:100px;margin-top:1rem;"><b>classi</b></h1></center>';

echo '<center><img src="resources/animations/exploding-loader.gif"></center>';

echo '</html>';

$redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . '/vaultdoor.php';
header('Refresh:7; url=' . filter_var($redirect_uri, FILTER_SANITIZE_URL));