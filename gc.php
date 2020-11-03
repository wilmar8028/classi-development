<?php
require_once 'vendor/autoload.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setAuthConfig('credentials.json');
$client->addScope("email");
$client->addScope("profile");
$client->setScopes(Google_Service_Classroom::CLASSROOM_COURSES_READONLY);

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;

  echo 'Name: ' . $name . '\nEmail: ' . $email;

  $service = new Google_Service_Classroom($client);

  // Print the first 10 courses the user has access to.
  $optParams = array(
    'pageSize' => 10
  );
  $results = $service->courses->listCourses($optParams);

  if (count($results->getCourses()) == 0) {
    echo "No courses found.\n";
  } else {
    echo "Courses:\n";
    foreach ($results->getCourses() as $course) {
      echo("%s (%s)\n", $course->getName(), $course->getId());
    }

} else {
  echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
}
?>