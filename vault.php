<?php
echo '
<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
<style>body {font-family: 'Comfortaa', cursive;}</style>
<body>
';

echo '<center style="margin-top:2rem">';
echo '<h1>Welcome to classi!</h1>'
echo '</center>';

sleep(3);
ob_clean();

echo '<center style="margin-top:2rem">';
echo '<img src="resources/animations/exploding-loader.gif">';
echo '</center>';

sleep(7);
ob_clean();

echo '<center style="margin-top:2rem">';
echo '<h1 style="font-size:100px"><b>classi</b></h1>';
echo '</center>';



$redirect_uri = 'https://' . $config['site-domain'] . '/vault.php';
header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));