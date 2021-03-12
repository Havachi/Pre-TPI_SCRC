<?php
/**
 * This class exist simply to make Database interaction and PDO easier to use in my projects
 * It is supposed to work with any project
 * @author Alessandro Rossi
 * @version 1.0
 */
//namespace PDOWrapper;
require "settings.ini.php";
//use \PDO;

class DBConnection
{
  /** @var string, MySQL Hostname */
  private $hostname = 'localhost';

  /** @var string, Database Username*/
  private $userName;

  /** @var string, Database Password*/
  private $pass;

  /** @var string, Database Hostname + Database Name = dsn*/
  private $dsn;

  /** @var array, The database settings*/
  private $settings;

  /** @var object, Database PDO object*/
  private $pdo;

  /** @var object, PDO Statement*/
  private $statement;

  /** @var array, Query Parameters*/
  private $parameters;

  /** @var bool, true if connected to DB*/
  private $Connected = false;

  private $success;
  /**
   * This is the constructor for the DBConnection object
   *
   * @param string $hostname This is the hostname of the DB
   * @param string $userName This is the username used to connect to the DB
   * @param string $password This is the password used to connect to the DB
   * @param string $dbname This is the database name which you want to connect to
   */
  public function __construct(){
    $this->settings = parse_ini_file("settings.ini.php");
    $this->userName = $this->settings['user'];
    $this->pass = $this->settings['password'];
    $this->dsn = "mysql:host=".$this->settings['host'].";dbname=".$this->settings['dbname'];
    $this->parameters = array();
    $this->openConnection();
  }

  /**
   * This method create a new PDO object and open the connection with the database
   *
   */
  private function openConnection(){
    try
    {
      $db = new PDO($this->dsn,$this->userName,$this->pass);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $this->pdo = $db ;
      $this->Connected = true;
    }
    catch (PDOException $e)
    {
      echo "Aie, aie, aie, problème de connexion avec la base de donnée";
      throw $e;
    }
  }

  /**
   * This small method close the current opened DB Connection, if you need to close it
   * NOTES: the connection closes automatically
   */
  public function CloseConnection()
  {
  	 		$this->pdo = null;
  }
  /**
   * This function initialize query, in order to exectue it.
   * More specifically, this function open the connection if it isn't, then it prepare the query, bind parameters to it, and finally excecute the query
   * @param string $query The query to initialize
   * @param array $parameters The parameters to initialize with the query
   * @author Alessandro Rossi
   */
  private function Init($query,$parameters = ""){
    if (!$this->Connected) {$this->openConnection();}
    try {
      $this->statement = $this->pdo->prepare($query);
      $this->bindMore($parameters);
      if (!empty($this->parameters)) {
        foreach ($this->parameters as $param => $value) {
          if(is_int($value[1])) {
              $type = PDO::PARAM_INT;
          } else if(is_bool($value[1])) {
              $type = PDO::PARAM_BOOL;
          } else if(is_null($value[1])) {
              $type = PDO::PARAM_NULL;
          } else {
              $type = PDO::PARAM_STR;
          }
          // Add type when binding the values to the column
          $this->statement->bindValue($value[0], $value[1], $type);
        }
      }
        $this->statement->execute();
    } catch (PDOException $e) {
      echo "Aie, aie, aie, problème de connexion avec la base de donnée";
      throw $e;
    }
    $this->parameters = array();
  }
  /**
  *	Add the parameter to the parameter array
  *
  *	@param string $para the parameter
  *	@param string $value the value
  */
  public function bind($para, $value)
  {
    $this->parameters[sizeof($this->parameters)] = [":" . $para , $value];
  }

  /**
  *	Add more parameters to the parameter array
  *
  *	@param string $parray
  */
  public function bindMore($parray)
	{
    if (empty($this->parameters) && is_array($parray)) {
      $columns = array_keys($parray);
      foreach ($columns as $i => &$column) {
          $this->bind($column, $parray[$column]);
      }
		}
	}
  /**
   * This method is the main method from this class, it return values depending of the used command,
   * For select command, the function return an array containing all selected rows
   * For insert, update and delete, the function return the number of affected rows
   * any thing else will return null
   * @param  string $query The query to execute
 	 * @param  array  $params The array containing all parameters
 	 * @param  int    $fetchmode The fetch mode used, default "PDO::FETCH_ASSOC", will return values in an associative array
   * @return mixed
   */
  public function query($query,$params = null, $fetchmode = PDO::FETCH_ASSOC)
  {
    $query = trim($query);
    $this->Init($query,$params);
    $rawSqlCommand = explode(" ", preg_replace("/\s+|\t+|\n+/", " ", $query));
    $sqlCommand = strtolower($rawSqlCommand[0]);
    if ($sqlCommand === 'select') {
      return $this->statement->fetchAll($fetchmode);
    }
    elseif ( $sqlCommand === 'insert' ||  $ssqlCommand === 'update' || $sqlCommand === 'delete' ) {
      return $this->statement->rowCount();
    }
    else {
      return NULL;
    }
  }
  /**
   * This function is used for getting a entire column from a table
   * @param  string $query The query to execute
 	 * @param  array  $params The array containing all parameters
   * @return array
   */
  public function column($query,$params = null)
  {
    $this->Init($query,$params);
    $Columns = $this->statement->fetchAll(PDO::FETCH_NUM);
    $column = null;
    foreach($Columns as $cells) {
      $column[] = $cells[0];
    }
    return $column;
  }
  /**
   * This function is used for getting a entire row from a table
   * @param  string $query The query to execute
 	 * @param  array  $params The array containing all parameters
   * @param  int    $fetchmode The fetch mode used, default "PDO::FETCH_ASSOC", will return values in an associative array
   * @return array
   */
  public function row($query,$params = null,$fetchmode = PDO::FETCH_ASSOC)
		{
			$this->Init($query,$params);
			return $this->statement->fetch($fetchmode);
		}
    /**
  *	This method return only a single field
  *
  * @param  string $query The query to execute
  * @param  array  $params The array containing all parameters
  *	@return string
  */
  public function single($query,$params = null)
    {
      $this->Init($query,$params);
      return $this->statement->fetchColumn();
    }
}
