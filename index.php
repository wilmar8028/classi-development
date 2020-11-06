<?php
require_once __DIR__.'/vendor/autoload.php';
require 'config/config.php';
include 'func.php';

function authuser1() {
  if(isset($_COOKIE['authuser1'])) {
    $authuser1value = '?authuser=1';
    return $authuser1value;
  }
}

session_start();

include 'gauthinfo.php';

if (isset($_SESSION['access_token'])) {
  $client->setAccessToken($_SESSION['access_token']);

  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;
  $fname =  $google_account_info->given_name;
  $profile =  $google_account_info->picture;
  setcookie('auth-login-hint', $email, time() + (86400 * 30), "/");

  echo '<center>';

  echo '<h1 style="margin-top:2rem">' . $config['welcome-back-message'] . ' ' . $fname . '</h1>';

  //echo '<img src="' . $profile . '">' . '<br>' . $config['welcome-back-message'] . ' ' . $fname . '<br>' . $email . '<br>';

  $service = new Google_Service_Classroom($client);
  $optParams = array('pageSize' => 10);
  $results = $service->courses->listCourses($optParams);

  echo '<br>';

if (count($results->getCourses()) == 0) {
    echo "No courses found.\n";
  } else {
    foreach ($results->getCourses() as $course) {
      if ( $course->getCourseState() == 'ACTIVE' ) {
      echo '<h3><a href="' . $course->getAlternateLink() . authuser1() . '" target="_blank">' . $course->getName() . '</a> (' . $course->getId() . ')</h3>';
    }
    }
}

echo '<br><form method="post"><input type="submit" name="logout" value="Logout"/>';
echo '<br><br><input type="submit" name="authuser1" value="Set Auth User 1"/></form>';

if(isset($_POST['logout'])) {
    logout($config['site-name']);
  }

if(isset($_POST['authuser1'])) {
    setcookie('authuser1', '1', time() + (86400 * 30 * 9999), "/");
    ob_clean();
    sleep(1);
    echo "<center><p style='margin-top:100px'>Success! Auth user set! Returning to " . $config['site-name'] ."...</p></center>";
    header("Refresh:3");
  }

} else {
  $redirect_uri = 'https://' . $config['site-domain'] . '/vaultdoor.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
