<?php
require 'config/config.php';

function logout($sitename) {
  setcookie('auth-login-hint', '', time() - 3600);
  session_unset();
  session_destroy();
  ob_clean();
  sleep(1);
  echo "<center><p style='margin-top:100px'>Deauthenticated! Returning to " . $sitename . "...</p></center>";
  header("Refresh:3");
}
