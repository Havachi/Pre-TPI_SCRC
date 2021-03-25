<?php
require_once 'DBConnection.php';

/**
 * This function get the entier list of user and sort it.
 *
 * @return array
 * @author Alessandro Rossi
 */
function fetchLeaderboard(){
  $query = "SELECT userFirstName, userLastName, userPBScore FROM users ORDER BY userPBScore DESC";
  try {
    $db = new DBConnection;
    $leaderboard = $db->query($query);
  }
  catch (PDOException $e) {
    throw $e;
  }
  return $leaderboard;
}

/**
 * This function get the current user position in leaderboard
 *
 * @return int
 * @author Alessandro Rossi
 */
function getUserPos(){
  $pos=1;
  $query = "SELECT userEmail, userPBScore FROM users ORDER BY userPBScore DESC";
  try {
    $db = new DBConnection;
    $leaderboard = $db->query($query);
  }
  catch (PDOException $e) {
    throw $e;
  }
  foreach ($leaderboard as $user) {
    foreach ($user as $key => $value) {
      if ($key == "userEmail") {
        if ($value == $_SESSION['userdata']['userEmailAddress']) {
          return $pos;
        }
      }
    }
    $pos++;
  }
}
