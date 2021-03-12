<?php
require_once 'DBConnection.php';

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
        if ($value == $_SESSION['userEmailAddress']) {
          return $pos;
        }
      }
    }
    $pos++;
  }
}
