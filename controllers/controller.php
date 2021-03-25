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
function displayAdminPage(){
  require "views/admin.php";
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
      unset($_SESSION['postdata']);
      header('Location: /index.php?action=login');
      require("views/login.php");

    }catch (databaseError $e){
      $error = array('databaseError' => $e->getMessage());
      unset($_SESSION['postdata']);
      header('Location: /index.php?action=login');
      require("views/login.php");
      exit();
    }
    if ($isLoginCorrect === true) {
      createSession($userLoginData['inputUserEmail']);
      $_GET['action'] = "home";
      if (!headers_sent()) {
        unset($_SESSION['postdata']);
        header("Location: /index.php?action=home");
        $_POST['submitType'] = 'confirm';
      }

      require("views/home.php");
    }else {
      if (!isset($error['loginError'])) {
        $error = array('loginError' => 'Adresse E-Mail ou mot de passe incorrect, veuillez reéssayer');
        unset($_SESSION['postdata']);
        header('Location: /index.php?action=login');
        require("views/login.php");
        exit();
      }
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
        $error = array('registerError' => $e->getMessage());
        unset($_SESSION['postdata']);
        header('Location : /index.php?action=register');
        require("views/register.php");
        exit();
      } catch (invalidPassword $e){
        $error = array('registerError' => $e->getMessage());
        unset($_SESSION['postdata']);
        header('Location : /index.php?action=register');
        require("views/register.php");
        exit();
      }

      $_GET['action'] = "login";
      $infos = array('loginOK' => "Compte créé!<br/>Veuillez vous connecter");
      unset($_SESSION['postdata']);
      header("Location: /index.php?action=login");
      require "views/login.php";
    }else {
      $error = array('passwordError' => "Les mots de passe de correspondent pas");
      unset($_SESSION['postdata']);
      header('Location : /index.php?action=register');
      require("views/register.php");
      exit();
    }
  }else {
    displayRegister();
  }
}

/**
 * This function controle how the concours react based on user interaction
 *
 * @author Alessandro Rossi
 */
function concoursControle(){
  //Checks if the client already has settings, if not it initialize the settings
  $flags = array();
  $flags['hint'] = false;

  $flags['reset'] = false;
  if (empty($_SESSION['Settings']['Concours'])) {
    $flags['init'] = "NOTOK";
  }else {
    $Settings_Concours = $_SESSION['Settings']['Concours'];
    $flags['init'] = "OK";
  }


  if (!empty($_SESSION['postdata'])) {
    if ($_SESSION['postdata']['userInputLatitude'] !== "" && $_SESSION['postdata']['userInputLongitude'] !== "") {
      $postdata = $_SESSION['postdata'];
      $flags['postdata'] = "set";
      if (isset($postdata['submitType'])) {
        if ($postdata['submitType'] === "validate") {
          $flags['submitType'] = "validate";
        }elseif ($postdata['submitType'] === "try") {
          $flags['submitType'] = "try";
        }else {
          $flags['submitType'] = "none";
        }
      }
    }else {
      if ($Settings_Concours['attemptsNumber'] !== 0) {
        $flags['postdata'] = "setattempts";
        $flags['submitType'] = "attempts";
      }else {
        $flags['postdata'] = "unset";
      }
    }
  }else {
    $flags['postdata'] = "unset";
  }
    if (isset($_GET['reset'])) {
      $flags['reset'] = $_GET['reset'];
    }

  if (isset($_GET['hint'])) {
    if ($_GET['hint'] <= 3 || $_GET['hint'] >= 0) {
      useHint();
      $flags['hint'] = true;
    }
  }
  if ($flags['init'] === "OK") {
    if ($flags['postdata'] === "set" || $flags['postdata'] === "setattempts") {
      if ($flags['reset']) {
        concoursFirstTime();
      }
      if ($flags['submitType'] === "validate" || $flags['submitType'] === "attempts") {
        if ((isset($_SESSION['postdata']['userInputLatitude']) && isset($_SESSION['postdata']['userInputLongitude'])) && ($_SESSION['postdata']['userInputLatitude'] !== "" && $_SESSION['postdata']['userInputLongitude'] !== "" )) {
          $_SESSION['postdata']['submitType'] = "delete";
          coucoursValidate($_SESSION['postdata']['userInputLatitude'],$_SESSION['postdata']['userInputLongitude']);
          clearPostData(0);
          require "views/concoursLogged.php";
        }elseif($flags['postdata'] === "setattempts") {
          $bestAttemptsCoordinates=calculateBestAttempt();
          coucoursValidate($bestAttemptsCoordinates['Lat'],$bestAttemptsCoordinates['Long']);
          clearPostData(0);
          require "views/concoursLogged.php";
        }else {
          $flags['postdata'] = 'unset';
        }
      }elseif ($flags['submitType'] === "try") {
        coucoursAttempt($_SESSION['postdata']['userInputLatitude'],$_SESSION['postdata']['userInputLongitude']);
        clearPostData(0);
        require "views/concoursLogged.php";
      }
    }elseif ($flags['postdata'] === "unset") {
      if ($flags['reset']){
        concoursFirstTime();
      }else {
        concoursComeback();
      }
      if ($flags['hint']) {
        concoursComeback();
      }
    }
  }elseif ($flags['init'] === "NOTOK") {
    if ($flags['postdata'] === "unset") {
      concoursFirstTime();
    }
  }

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
  //header("Location: /index.php?action=profile"); //Make the server die
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

function upload(){
  require "models/upload.php";
}

/*End of Other*/

/*Test*/
function setTestEnv()
{
  $userData = array();

  $userData['userID'] = 999;
  $userData['userFirstName'] = "Alessandro";
  $userData['userLastName'] = "Rossi";
  $userData['userEmailAddress'] = "alessandro.rossi7610@gmail.com";
  $userData['userRole'] = "1";
  $_SESSION['userdata'] = $userData;
  $_SESSION['isLogged'] = true; 
  require 'views/home.php';
}

?>
