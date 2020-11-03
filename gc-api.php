//
//
// Code Snippets
//
//

//Open URL in New Tab
// echo '<script>window.open(url, "_blank");</script>';





//
//
// G Classroom
//
//

<?php
require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Classroom API PHP Quickstart');
    $client->setScopes(Google_Service_Classroom::CLASSROOM_COURSES_READONLY);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}


// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Classroom($client);

// Print the first 10 courses the user has access to.
$optParams = array(
  'pageSize' => 10
);
$results = $service->courses->listCourses($optParams);

if (count($results->getCourses()) == 0) {
  print "No courses found.\n";
} else {
  print "Courses:\n";
  foreach ($results->getCourses() as $course) {
    printf("%s (%s)\n", $course->getName(), $course->getId());
  }
}





//
//
// Google Oauth
//
//

<?php
require_once 'vendor/autoload.php';
 
// init configuration
$clientID = '<YOUR_CLIENT_ID>';
$clientSecret = '<YOUR_CLIENT_SECRET>';
$redirectUri = '<REDIRECT_URI>';
  
// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
 
// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);
  
  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;
 
  // now you can use this profile info to create account in your website and make user logged in.
} else {
  echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
}
?>










//
//
// Complete
//
//

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
