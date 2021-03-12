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
      if (!headers_sent()) {
        header("Location: /index.php?action=home");
      }

      require("views/home.php");
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

      $_GET['action'] = "login";
      header("Location: /index.php?action=login");
      $infos[]="Compte créé!<br/>Veuillez vous connecter";
      require "views/login.php";
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
  header("Location: /index.php");
  exit();
}


/*End of Other*/
?>
