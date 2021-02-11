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
    $dbname = $localConnectionData['dbname'];
    $dsn = "mysql:host=".$hostname.";dbname=".$dbname;
    
    $dbconnect = new PDO($dsn, $userName, $userPwd);

    /*
    if ($dbconnect->connect_error) {
        die("Database connection failed: " . $dbconnect->connect_error);
    }*/
    return $dbconnect;
}
function executeQuery($query)
{
  $db=openDBConnexion();
  $result = $db->exec($query);
}
function executeQuerySelectSingle($query){
  $db=openDBConnexion();
  $result = $db->query($query)->fetch();
}
function executeQuerySelectMult($query){
  $db=openDBConnexion();
  $data = $pdo->query($query)->fetchAll();
}
