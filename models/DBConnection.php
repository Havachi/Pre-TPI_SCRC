<?php
require_once "exceptions/DatabaseError.php";
/**
 * This function will open a new connection with the database
 *
 * @return dbconnection The connection with the databases
 * @author Alessandro Rossi
 */
function openDBConnexion(){
    $useLocal = true;
    $localConnectionData = array('hostname' => 'localhost' ,'username' => 'SCRCConnector', 'password' => 'Pa$$w0rd', 'dbname' => 'scrc' );

    $hostname = $localConnectionData['hostname'];
    $userName = $localConnectionData['username'];
    $userPwd = $localConnectionData['password'];
    $dbName = $localConnectionData['dbname'];

    try{
      $dbconnect = mysqli_connect($hostname, $userName, $userPwd, $dbName);
    }catch(mysqli_sql_exception $e){
      throw new SiteUnderMaintenanceExeption ;
    }
    if ($dbconnect->connect_error) {
        die("Database connection failed: " . $dbconnect->connect_error);
    }
    return $dbconnect;
}
function closeDBConnection($Connection){
    mysqli_close($Connection);
}
function executeQueryInsert($insertQuery){
    try {
      $dbConnexion = openDBConnexion();
    } catch (SiteUnderMaintenanceExeption $e) {
      throw new SiteUnderMaintenanceExeption ;
    }


    if (mysqli_query($dbConnexion, $insertQuery)) {
      return mysqli_affected_rows($dbConnexion);
    } else {
        throw new invalidDatabaseConnection();
    }
}
function executeQueryUpdate($updateQuery){
  try {
    $dbConnexion = openDBConnexion();
  } catch (SiteUnderMaintenanceExeption $e) {
    throw new SiteUnderMaintenanceExeption ;
  }
  if (mysqli_query($dbConnexion, $updateQuery)) {
      return mysqli_affected_rows($dbConnexion);
  } else {
      throw new invalidDatabaseConnection();
  }
}
function executeQuerySelect($selectQuery){
    require_once "exceptions/DatabaseError.php";
    $queryResult = null;

    try {
      $dbConnexion = openDBConnexion();
    } catch (SiteUnderMaintenanceExeption $e) {
      throw $e ;
    }
    if ($result = mysqli_query($dbConnexion, $selectQuery)) {
        if (mysqli_num_rows($result) > 0) {
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_row($result);
                $queryResult = array();
                foreach ($row as $value) {
                    array_push($queryResult, $value);
                }
            } else {
                $queryResult = array();
                while ($row = $result->fetch_assoc()) {
                    $queryResult[] = $row;
                }
            }
        }
    } else {
        throw new invalidDatabaseConnection();
    }
    //$result->free();
    return $queryResult;
}
