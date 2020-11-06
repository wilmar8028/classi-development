<?php
require 'config/config.php';

function logout($sitename) {
  setcookie('auth-login-hint', '', time() - 3600);
  session_unset();
  session_destroy();
  ob_clean();
  sleep(1);
  echo "<center><p style='margin-top:100px'><img src='resources/animations/imploding-loader.gif'><br>Deauthenticated! Returning to " . $sitename . "...</p></center>";
  header("Refresh:3");
}

function setAuthUser($sitename) {
  setcookie('authuser1', '1', time() + (86400 * 30 * 9999), "/");
  ob_clean();
  sleep(1);
  echo "<center><p style='margin-top:100px'>Success! Auth user set! Returning to " . $config['site-name'] ."...</p></center>";
  header("Refresh:3");
}
