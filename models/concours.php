<?php
/**
 * This function is run every time the user enter the contest
 * It sets every used variable to their initial values
 * @author Alessandro Rossi
 */
function concoursInit(){
  $_SESSION['currentLevel']=1;
  $_SESSION['pathToImage']="/content/images/".$_SESSION['currentLevel'].".jpg";
  $_SESSION['attemptsNumber']=0;
  $_SESSION['userScores'] = array(
  'lvl1' => 0 ,'lvl2' => 0 ,
  'lvl3' => 0 ,'lvl4' => 0 ,
  'lvl5' => 0 ,'lvl6' => 0 ,
  'lvl7' => 0 ,'lvl8' => 0 ,
  'lvl9' => 0 ,'lvl10' => 0);
  $_SESSION['tryScores'] = array('Try1' => 0,'Try2' => 0,'Try3' => 0);
  $_SESSION['attempts'] = array('Try1' => array('Lat' => 0,'Long' => 0),'Try2' => array('Lat' => 0,'Long' => 0),'Try3' => array('Lat' => 0,'Long' => 0));
  $_SESSION['hints'] = 3;
  $_SESSION['levelHints'] = array();
}

/**
 * This function is run every time the user go to the next level
 * It setup the variables for the next level
 * @author Alessandro Rossi
 */
function nextLevel(){
  if ($_SESSION['currentLevel'] == 10) {
    endConcours();
  }else {
    $_SESSION['currentLevel']=$_SESSION['currentLevel']+1;
    $_SESSION['pathToImage']="/content/images/".$_SESSION['currentLevel'].".jpg";
    $_SESSION['attemptsNumber']=0;
    $_SESSION['tryScores'] = array('Try1' => 0,'Try2' => 0,'Try3' => 0);
    $_SESSION['attempts'] = array('Try1' => array('Lat' => 0,'Long' => 0),'Try2' => array('Lat' => 0,'Long' => 0),'Try3' => array('Lat' => 0,'Long' => 0));
    $_SESSION['hints'] = 3;
    $_SESSION['levelHints'] = array();
    Header("Location : /index.php?action=concours");
    require "views/concoursLogged.php";
    exit();
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
  if ($_SESSION['hints'] == 3) {
    $query = "SELECT hint1 FROM hints WHERE imageID = :imageID";
  }elseif ($_SESSION['hints'] == 2) {
    $query = "SELECT hint2 FROM hints WHERE imageID = :imageID";
  }elseif ($_SESSION['hints'] == 1) {
    $query = "SELECT hint3 FROM hints WHERE imageID = :imageID";
  }
  if (isset($query)) {
    try {
      $db = new DBConnection;
      $hint = $db->single($query,array("imageID"=>$_SESSION['currentLevel']));
    }
    catch (PDOException $e) {
      throw $e;
    }

    if ($_SESSION['hints']===3) {
      $_SESSION['levelHints'][0] = $hint[0]['hint1'];
    }elseif($_SESSION['hints']===2) {
      $_SESSION['levelHints'][1] = $hint[0]['hint2'];
    }elseif($_SESSION['hints']===1){
      $_SESSION['levelHints'][2] = $hint[0]['hint3'];
    }
    $_SESSION['hints']--;
    require 'views/concoursLogged.php';
  }
}

/**
 * This function is run every time the user press the try button
 * It calculate the distance between the user answer and the solution
 * and the calculate the score to finally show it to the user
 * @author Alessandro Rossi
 */
function coucoursAttempt(){
  if ($_SESSION['attemptsNumber'] !== 3) {
    if (isset($_SESSION['attemptsNumber'])) {
      $_SESSION['attemptsNumber'] = $_SESSION['attemptsNumber']+1;
      $_SESSION['attempts']["Try".$_SESSION['attemptsNumber']]['Lat'] = $_POST['userInputLatitude'];
      $_SESSION['attempts']["Try".$_SESSION['attemptsNumber']]['Long'] = $_POST['userInputLongitude'];
      $dbSolution = fetchSolution($_SESSION['currentLevel']);
      $dbLat = $dbSolution[0]['imagePosLat'];
      $dbLon = $dbSolution[0]['imagePosLon'];
      $result = calculateDistance($_POST['userInputLatitude'],$_POST['userInputLongitude'],$dbLat,$dbLon);
      $_SESSION['tryScores']["Try".$_SESSION['attemptsNumber']] = calculateImageScore($result);

      require "views\concoursLogged.php";
    }
  }
}

function calculateBestAttempt(){
  $Try1 = $_SESSION['tryScores']['Try1'];
  $Try2 = $_SESSION['tryScores']['Try2'];
  $Try3 = $_SESSION['tryScores']['Try3'];
  if ( $Try1 >= $Try2 && $Try1 >= $Try3 ) {
    $bestAttemps['Lat'] = floatval($_SESSION['attempts']['Try1']['Lat']);
    $bestAttemps['Long'] = floatval($_SESSION['attempts']['Try1']['Long']);
  }
  elseif ( $Try2 >= $Try1 && $Try2 >= $Try3 ) {
    $bestAttemps['Lat'] = floatval($_SESSION['attempts']['Try2']['Lat']);
    $bestAttemps['Long'] = floatval($_SESSION['attempts']['Try2']['Long']);
  }
  elseif ( $Try3 >= $Try1 && $Try3 >= $Try2 ) {
    $bestAttemps['Lat'] =floatval($_SESSION['attempts']['Try3']['Lat']);
    $bestAttemps['Long'] =floatval($_SESSION['attempts']['Try3']['Long']);
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
  $dbSolution = fetchSolution($_SESSION['currentLevel']);
  $dbLat = $dbSolution[0]['imagePosLat'];
  $dbLon = $dbSolution[0]['imagePosLon'];
  try {
    $result = calculateDistance($inputLat,$inputLon,$dbLat,$dbLon);
    $score = calculateImageScore($result);
  } catch (\Exception $e) {

  }
  $_SESSION['userScores']['lvl'.$_SESSION['currentLevel']] = $score;
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
  $values=array(':imageID' => $level);
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
  require_once "DBConnection.php";
  $query = "SELECT userPBScore FROM users where userID = :userID" ;
  $values=array('userID' => $_SESSION['userID']);
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
  if ($diff <= 125) {
    $score = 10;
  }elseif ($diff >= 126 && $diff <= 250) {
    $score = 9;
  }elseif ($diff >= 251 && $diff <= 500) {
    $score = 8;
  }elseif ($diff >= 501 && $diff <= 1000) {
    $score = 7;
  }elseif ($diff >= 1001 && $diff <= 2000) {
    $score = 6;
  }elseif ($diff >= 2001 && $diff <= 4000) {
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
  $totalScore = 0;
  foreach ($_SESSION['userScores'] as $lvl => $score) {
    $totalScore = $totalScore + $score;
  }
  $_SESSION['totalScore'] = $totalScore;
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
  $filename="games/lastGameUser".$_SESSION['userID'];
  if (file_exists($filename)) {
    file_put_contents($filename,"");
  }
  foreach ($_SESSION['userScores'] as $lvl => $score) {
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
  $filename="games/lastGameUser".$_SESSION['userID'];
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
