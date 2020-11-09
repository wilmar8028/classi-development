<?php

echo '
<html>
<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
<style>
    body {
        font-family: Comfortaa;
    }
</style>
<body>
';

echo '<center><h1 style="font-size:100px;margin-top:1rem;"><b>classi</b></h1></center>';

echo '<center><img src="resources/animations/exploding-loader.gif"></center>';

echo '</html>';

$redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . '/vaultdoor.php';
header('Refresh:7; url=' . filter_var($redirect_uri, FILTER_SANITIZE_URL));