<?php
require "models/login.php";
require "models/register.php";
require "models/concours.php";
require "models/leaderboard.php";

/*Display only part*/
function displayHome(){
  require "views/home.php";
}
function displayLogin(){
  require "views/login.php";
}
function displayRegister(){
  require "views/register.php";
}
function displayConcours(){
  require "views/concoursLogged.php";
}
function displayConcoursNotLogged(){
  require "views/concoursUnlogged.php";
}
function displayLeaderboard(){
  require "views/leaderboard.php";
}

/*End of Display only part*/


/*Model access functions*/

/**
 * This function firstly check if every fields of the form was set,
 * then send data to the model or redirect the user
 * @param array $userLoginData is the post data received from the login page
 * @return void
 * @author Alessandro Rossi
 */
function login($userLoginData){
  if(isset($userLoginData['inputUserEmail']) && isset($userLoginData['inputUserPassword'])){
    $isLoginCorrect = false;
    try {
      $isLoginCorrect=isLoginCorrect($userLoginData);
    } catch (loginError $e) {
      $error = array('loginError' => $e->getMessage());
      displayLogin();
    }catch (databaseError $e){
      throw $e;
    }
    if ($isLoginCorrect === true) {
      createSession($userLoginData['inputUserEmail']);
      $_GET['action'] = "home";
      safe_redirect("/index.php?action=home",false);
    }else {
      throw new loginError;
    }
  }else {
    displayLogin();
  }
}
/**
 * This function firstly check if every fields of the form was set,
 * then verify if the confirmation of the password is equal to the password,
 * And finally send data to the model or redirect the user
 *
 * @param array $userRegisterData is the post data received from the register page
 * @return void
 * @author Alessandro Rossi
 */
function register($userRegisterData)
{
  if(isset($userRegisterData['inputUserLastName']) && isset($userRegisterData['inputUserFirstName']) && isset($userRegisterData['inputUserEmail']) && isset($userRegisterData['inputUserPassword']) && isset($userRegisterData['inputUserPasswordConf'])){
    if ($userRegisterData['inputUserPassword'] === $userRegisterData['inputUserPasswordConf']) {
      try {
        registerInDB($userRegisterData);
      } catch (alreadyInUseEmail $e) {
        displayRegister();

      }

      $_GET['action'] = "home";
      require "views/Home.php";
    }else {
      $_GET['error'] = "err:invdb";
      displayRegister();
    }
  }else {
    displayRegister();
  }
}

function displayConcoursLevel($currentLevel){
  concoursInit($currentLevel);
  require "views/concoursLogged.php";
}

function prepareLeaderboard(){
  $leaderboard = fetchLeaderboard();
  require "views/leaderboard.php";
}
function displayProfile(){
  $PB=fetchPB();
  $PB = $PB[0]['userPBScore'];
  $Pos=getUserPos();
  $lastGame = loadLastGame();
  require "views/profile.php";
}

/*End of Model access functions*/
/* Other */
function logout(){
  session_unset();
  session_destroy();
  safe_redirect("/index.php");
  exit();
}

function safe_redirect($url, $exit=true){
if(!headers_sent()){
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: ' . $url);
  header("Connection: close");
}     


echo '<html>';
echo '<head><title>Redirecting you...</title>';
echo '<meta http-equiv="Refresh" content="0;url='.$url.'" />';
echo '</head>';
echo '<body onload="location.replace(\''.$url.'\')">';
 
// If the javascript and meta redirect did not work,
// the user can still click this link
echo 'You should be redirected to this URL:<br />';
echo "<a href="$url">$url</a><br /><br />";
 
echo 'If you are not, please click on the link above.<br />';
 
echo '</body>';
echo '</html>';
// Stop the script here (optional)
if ($exit){exit()};
}
/*End of Other*/
