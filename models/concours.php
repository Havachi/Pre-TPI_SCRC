<?php

/**
 * This function will initalize the concours whenever the play first enter or reset the coucours
 */
function concoursFirstTime(){
  concoursInit();
  require "views/concoursLogged.php";
  if (isset($_GET['reset'])) {
    unset($_GET['reset']);
  }
  exit();
}
/**
 * This function will display the login page
 */
function concoursComeback(){
  require "views/concoursLogged.php";
  exit();
}
/**
 * This function is run every time the user enter the contest
 * It sets every used variable to their initial values
 * @author Alessandro Rossi
 */
function concoursInit(){
  $settings_Concours = array();
  $settings_Concours['currentLevel']=1;
  $settings_Concours['currentImage']= randomImage(1);
  $settings_Concours['exclusionList'] = $_SESSION['Settings']['Concours']['exclusionList'];
  $settings_Concours['pathToImage']="/content/images/".$settings_Concours['currentImage'].".jpg";
  $settings_Concours['attemptsNumber']=0;
  $settings_Concours['userScores'] = array(
  'lvl1' => 0 ,'lvl2' => 0 ,
  'lvl3' => 0 ,'lvl4' => 0 ,
  'lvl5' => 0 ,'lvl6' => 0 ,
  'lvl7' => 0 ,'lvl8' => 0 ,
  'lvl9' => 0 ,'lvl10' => 0);
  $settings_Concours['tryScores'] = array('Try1' => 0,'Try2' => 0,'Try3' => 0);
  $settings_Concours['attempts'] = array('Try1' => array('Lat' => 0,'Long' => 0),'Try2' => array('Lat' => 0,'Long' => 0),'Try3' => array('Lat' => 0,'Long' => 0));
  $settings_Concours['hints'] = 3;
  $settings_Concours['levelHints'] = array();
  $_SESSION['Settings']['Concours'] = $settings_Concours;
}

/**
 * This function is run every time the user go to the next level
 * It setup the variables for the next level
 * @author Alessandro Rossi
 */
function nextLevel(){
  $settings_Concours = $_SESSION['Settings']['Concours'];
  if ($settings_Concours['currentLevel'] == 10) {
    endConcours();
  }else {
    $settings_Concours['currentLevel']++;
    do {
      $nextLevel = randomImage($settings_Concours['currentImage']);
    } while ($nextLevel === $_SESSION['Settings']['Concours']['currentImage']);
    $settings_Concours['exclusionList'] = $_SESSION['Settings']['Concours']['exclusionList'];

    $settings_Concours['pathToImage']="/content/images/". $nextLevel .".jpg";
    $settings_Concours['attemptsNumber']=0;
    $settings_Concours['tryScores'] = array('Try1' => 0,'Try2' => 0,'Try3' => 0);
    $settings_Concours['attempts'] = array('Try1' => array('Lat' => 0,'Long' => 0),'Try2' => array('Lat' => 0,'Long' => 0),'Try3' => array('Lat' => 0,'Long' => 0));
    $settings_Concours['hints'] = 3;
    $settings_Concours['levelHints'] = array();
    $_SESSION['Settings']['Concours'] = $settings_Concours;
    clearPostData();
  }

}
/**
 * This function get the next hint for this image from the database
 *
 * @return void
 * @author Alessandro Rossi
 */
function useHint(){
  $strSep='\'';
  $settings_Concours = $_SESSION['Settings']['Concours'];
  if ($settings_Concours['hints'] == 3) {
    $query = "SELECT hint1 FROM hints WHERE imageID = :imageID";
  }elseif ($settings_Concours['hints'] == 2) {
    $query = "SELECT hint2 FROM hints WHERE imageID = :imageID";
  }elseif ($settings_Concours['hints'] == 1) {
    $query = "SELECT hint3 FROM hints WHERE imageID = :imageID";
  }
  if (isset($query)) {
    try {
      $db = new DBConnection;
      $hint = $db->single($query,array("imageID"=>$settings_Concours['currentImage']));
    }
    catch (PDOException $e) {
      throw $e;
    }

    if ($settings_Concours['hints']===3) {
      $settings_Concours['levelHints'][0] = $hint;
    }elseif($settings_Concours['hints']===2) {
      $settings_Concours['levelHints'][1] = $hint;
    }elseif($settings_Concours['hints']===1){
      $settings_Concours['levelHints'][2] = $hint;
    }
    $settings_Concours['hints']--;
    $_SESSION['Settings']['Concours'] = $settings_Concours;
  }
}

/**
 * This function is run every time the user press the try button
 * It calculate the distance between the user answer and the solution
 * and the calculate the score to finally show it to the user
 * @author Alessandro Rossi
 */
function coucoursAttempt(){
  $settings_Concours = $_SESSION['Settings']['Concours'];
  $postdata = $_SESSION['postdata'];
  if (isset($settings_Concours['attemptsNumber'])) {
    if ($settings_Concours['attemptsNumber'] !== 3) {
      $settings_Concours['attemptsNumber']++;
      $settings_Concours['attempts']["Try".$settings_Concours['attemptsNumber']]['Lat'] = $postdata['userInputLatitude'];
      $settings_Concours['attempts']["Try".$settings_Concours['attemptsNumber']]['Long'] = $postdata['userInputLongitude'];
      $dbSolution = fetchSolution($settings_Concours['currentImage']);
      $dbLat = $dbSolution[0]['imagePosLat'];
      $dbLon = $dbSolution[0]['imagePosLon'];
      $result = calculateDistance($postdata['userInputLatitude'],$postdata['userInputLongitude'],$dbLat,$dbLon);
      $settings_Concours['tryScores']["Try".$settings_Concours['attemptsNumber']] = calculateImageScore($result);
      $_SESSION['Settings']['Concours'] = $settings_Concours;
      $_SESSION['postdata'] = $postdata;
    }
  }
}

/**
 * This function will calculate the best attempt for a level and return which is the best
 *
 * @return array
 */

function calculateBestAttempt(){
  $settings_Concours = $_SESSION['Settings']['Concours'];
  $postdata = $_SESSION['postdata'];

  $Try1 = $settings_Concours['tryScores']['Try1'];
  $Try2 = $settings_Concours['tryScores']['Try2'];
  $Try3 = $settings_Concours['tryScores']['Try3'];
  if ( $Try1 >= $Try2 && $Try1 >= $Try3 ) {
    $bestAttemps['Lat'] = floatval($settings_Concours['attempts']['Try1']['Lat']);
    $bestAttemps['Long'] = floatval($settings_Concours['attempts']['Try1']['Long']);
  }
  elseif ( $Try2 >= $Try1 && $Try2 >= $Try3 ) {
    $bestAttemps['Lat'] = floatval($settings_Concours['attempts']['Try2']['Lat']);
    $bestAttemps['Long'] = floatval($settings_Concours['attempts']['Try2']['Long']);
  }
  elseif ( $Try3 >= $Try1 && $Try3 >= $Try2 ) {
    $bestAttemps['Lat'] =floatval($settings_Concours['attempts']['Try3']['Lat']);
    $bestAttemps['Long'] =floatval($settings_Concours['attempts']['Try3']['Long']);
  }
  return $bestAttemps;
}
/**
 * This function is run every time the user press the Next Button
 * It calculate the distance between the user answer and the solution
 * and the calculate the score to store it in an array
 * @author Alessandro Rossi
 */
function coucoursValidate($inputLat,$inputLon){
  $settings_Concours = $_SESSION['Settings']['Concours'];
  $postdata = $_SESSION['postdata'];

  $dbSolution = fetchSolution($settings_Concours['currentImage']);
  $dbLat = $dbSolution[0]['imagePosLat'];
  $dbLon = $dbSolution[0]['imagePosLon'];
  try {
    $result = calculateDistance($inputLat,$inputLon,$dbLat,$dbLon);
    $score = calculateImageScore($result);
  } catch (\Exception $e) {

  }
  $settings_Concours['userScores']['lvl'.$settings_Concours['currentLevel']] = $score;
  $_SESSION['Settings']['Concours'] = $settings_Concours;
  $_SESSION['postdata'] = $postdata;
  nextLevel();
}

/**
 * This function fetch the solution for this image from database, and return it
 *
 * @param int $level : The level which solutino need to be fetched
 * @return array : The solution, composed of latitude and longitude coordinates
 * @author Alessandro Rossi
 */
function fetchSolution($level){
  require_once "DBConnection.php";
  $query = "SELECT imagePosLat, imagePosLon FROM images where imageID = :imageID";
  $values=array('imageID' => $level);
  try {
    $db = new DBConnection;
    $result = $db->query($query,$values);
  }
  catch (PDOException $e) {
    throw $e;
  }
  return $result;
}
/**
 * This function fetch the Personal Best Score of an specific user from database, and return it
 *
 * @return int : The Personal Best Score of the selectec user
 * @author Alessandro Rossi
 */
function fetchPB(){
  $userData = $_SESSION['userdata'];
  $query = "SELECT userPBScore FROM users where userID = :userID" ;
  $values=array('userID' => $userData['userID']);
  try {
    $db = new DBConnection;
    $result = $db->query($query,$values);
  }
  catch (PDOException $e) {
    throw $e;
  }
  return $result;
}

/**
 * Calculates the great-circle distance between two points, with
 * the Haversine formula.
 * @param float $inputLat Latitude of start point in [deg decimal]
 * @param float $inputLon Longitude of start point in [deg decimal]
 * @param float $dbLat Latitude of target point in [deg decimal]
 * @param float $dbLon Longitude of target point in [deg decimal]
 * @return float Distance between points in [m] (same as earthRadius)
 * @author martinstoeckli @ https://stackoverflow.com/questions/10053358/measuring-the-distance-between-two-coordinates-in-php
 */
function calculateDistance($inputLat,$inputLon,$dbLat,$dbLon){
  if (isset($inputLat) && isset($inputLon) && isset($dbLat) && isset($dbLon)) {
  try {
    $inputLatRad = deg2rad($inputLat);
    $inputLonRad = deg2rad($inputLon);
    $dbLatRad = deg2rad($dbLat);
    $dbLonRad = deg2rad($dbLon);
  } catch (invalidInputException $e) {
    throw new $e;
  }
  $earthRadius = 6371000;//in meter

  $latDelta =  $dbLatRad - $inputLatRad;
  $lonDelta =  $dbLonRad - $inputLonRad;

  $angle = 2*asin(sqrt(pow(sin($latDelta / 2),2) +
  cos($inputLatRad) * cos($dbLatRad) * pow(sin($lonDelta / 2),2)));
  return $angle * $earthRadius;
  }
}

/**
 * Calculate the score from the difference in Meter of the user input and the solution in DB
 *
 * @param float $diff the difference in Meter of the user input and the solution in DB
 * @return int The score of the user
 * @author Alessandro Rossi
 */
function calculateImageScore($diff){
  $score = 0;
  if ($diff <= 500) {
    $score = 10;
  }elseif ($diff >= 5001 && $diff <= 1000) {
    $score = 9;
  }elseif ($diff >= 1001 && $diff <= 2000) {
    $score = 8;
  }elseif ($diff >= 2001 && $diff <= 2500) {
    $score = 7;
  }elseif ($diff >= 2501 && $diff <= 3000) {
    $score = 6;
  }elseif ($diff >= 3001 && $diff <= 4000) {
    $score = 5;
  }elseif ($diff >= 4001 && $diff <= 8000) {
    $score = 4;
  }elseif ($diff >= 8001 && $diff <= 16000) {
    $score = 3;
  }elseif ($diff >= 16001 && $diff <= 32000) {
    $score = 2;
  }elseif($diff > 32000){
    $score = 1;
  }
  return $score;
}
/**
 * This function is used only at the end of the concours,
 * it add-up all score and check if the PB in DB is greater or not,
 * and keeps the best of the two.
 *
 * @author Alessandro Rossi
 */
  function endConcours(){
  $settings_Concours = $_SESSION['Settings']['Concours'];


  $totalScore = 0;
  foreach ($settings_Concours['userScores'] as $lvl => $score) {
    $totalScore = $totalScore + $score;
  }
  $settings_Concours['totalScore'] = $totalScore;
  $userPB = fetchPB()[0];

  if ($userPB < $totalScore){
    $query = "UPDATE users SET userPBScore = :totalScore WHERE userID = :userID";
    $values = array("totalScore" => $totalScore,"userID" => $_SESSION['userID']);
    try {
      $db = new DBConnection;
      $result = $db->query($query,$values);
    }
    catch (PDOException $e) {
      throw $e;
    }
  }
  $_SESSION['Settings']['Concours'] = $settings_Concours;

  saveLastGame();
  require "views/finalScore.php";
}
/**
 * This function save the last played game of an user in a file on the server
 * This feature is used by the profile for showing the last game
 * @return    void
 * @author Alessandro Rossi
 */
function saveLastGame(){
  $settings_Concours = $_SESSION['Settings']['Concours'];
  $userData = $_SESSION['userdata'];
  $filename="games/lastGameUser".$userData['userID'];
  if (file_exists($filename)) {
    file_put_contents($filename,"");
  }
  foreach ($settings_Concours['userScores'] as $lvl => $score) {
    file_put_contents($filename,$score.";",FILE_APPEND);
  }
}

/**
 * This function load the last played game of an user from a file on the server
 * This feature is used by the profile for showing the last game
 * @return    void
 * @author Alessandro Rossi
 */
function loadLastGame(){
  $userData = $_SESSION['userdata'];
  $filename="games/lastGameUser".$userData['userID'];
  if (file_exists($filename)) {
    $lastGame = file_get_contents($filename);
    $lastGameArray = explode(';',$lastGame);
    unset($lastGameArray[10]);
    $result = array();
    foreach ($lastGameArray as $key => $score) {
      $result["lvl".$key+1] = $score;
    }
    return $result;
  }else {
    return null;
  }
}
/**
 * Select a random image from all images available
 *
 * @param int $currentLevel is the actual level where the player is
 * @return int The random image ID to use
 */
function randomImage($currentLevel){
  if ($currentLevel === 1) {
    //reset exclusionList, no check needed
    $randomImage = rand(1,$GLOBALS['COUNT_IMAGE']);
    $_SESSION['Settings']['Concours']['exclusionList'] = array(0=>$randomImage);
    return $randomImage;
  }else {
    do {
      $randomImage = rand(1,$GLOBALS['COUNT_IMAGE']);
    } while (checkExclusion($_SESSION['Settings']['Concours']['exclusionList'], $randomImage) !== true);
    $_SESSION['Settings']['Concours']['exclusionList'][] = $randomImage;
    return $randomImage;
  }
}
/**
 * Check the list of already used image
 *
 * @param array $exclusionList The list of already selected images
 * @param array $imageToCheck The image to check
 * @return bool
 */
function checkExclusion($exclusionList,$imageToCheck){
  $allClear = false;
  $allChecked = false;
  $imageOK = false;
  $i = 0;
  do {
    foreach ($exclusionList as $exclusion) {
      if ($imageToCheck === $exclusion) {
        $imageOK = false;
        $i++;
        return false;
      }else {
        $imageOK = true;
        $i++;
      }
      if ($i === count($exclusionList)) {
          $allChecked = true;
      }else {
        $allChecked = false;
      }
    }
    if ($allChecked === true && $imageOK === true) {
      $allClear = true;
      break;
    }
    if ($allChecked === true && $allClear === false) {
      return false;
      break;
    }
  } while ($allClear !== true);
  return true;
}
