<?php
require_once __DIR__.'/vendor/autoload.php';
require 'config/config.php';

session_start();

$client = new Google_Client();
$client->setApplicationName("classi");
$client->setAuthConfigFile('gcred.json');
$client->setRedirectUri('https://' . $config['site-domain'] . '/vaultdoor.php');
$client->addScope('email');
$client->addScope('profile');
$client->addScope(Google_Service_Classroom::CLASSROOM_COURSES_READONLY);
$client->setIncludeGrantedScopes(true);
$client->setLoginHint($_COOKIE['auth-login-hint']);

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  //echo "<center><p style='margin-top:100px'>Authenticated! Returning to " . $config['site-name'] . "...</p></center>";
  setcookie('authuser', '0', time() + (86400 * 30 * 9999), "/");
  $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . '/index.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
