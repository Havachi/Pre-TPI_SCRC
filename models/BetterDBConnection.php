parameters<?php
/**
 * This class exist simply to make Database interaction and PDO easier to use in my projects
 * It is supposed to work with any project
 * @author Alessandro Rossi
 * @version 0.1
 */
namespace PDOWrapper;
use \PDO;

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

  /** @var object, Database PDO object*/
  private $pdo;

  /** @var object, PDO Statement*/
  private $statement;

  /** @var array, PDO Statement*/
  private $parameters;

  /** @var bool, true if connected to DB*/
  private $Connected = false;

  /**
   * This is the constructor for the DBConnection object
   *
   * @param string $hostname This is the hostname of the DB
   * @param string $userName This is the username used to connect to the DB
   * @param string $password This is the password used to connect to the DB
   * @param string $dbname This is the database name which you want to connect to
   */
  public function __construct($hostname,$userName,$password,$dbname )
  {
      $this->userName = $userName;
      $this->pass = $password;
      $this->dsn = "mysql:host=".$hostname.";dbname=".$dbname;
      $this->openConnection($dsn, $userName, $userPwd);
  }
  /**
   * This method create a new PDO object and open the connection with the database
   *
   */
  private function openConnection(){
    try
    {
      $db = new PDO($this->dsn,$this->login,$this->pass);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      //$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
      $this->pdo = $db ;
      $this->Connected = true;
    }
    catch (PDOException $e)
    {
      echo "Aie, aie, aie, problème de connexion avec la base de donnée"
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
   * @param
   * @return    void
   * @author
   * @copyright
   */
  private function Init($query,$parameters = ""){
    if (!$this->Connected) {$this->openConnection();}
    try {
      $this->statement = $this->pdo->prepare($query);
      $this->bindMore($parameters);
      if (!empty($this->parameters)) {
        foreach ($this->parameters as $param) {
          $parameters = explode('\x7F', $param);
          $this->statement->bindParam($parameters[0],$parameters[1]);
        }
      }
      $this->success = $this->parameters-execute();
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
    $this->parameters[sizeof($this->parameters)] = ":" . $para . "\x7F" . utf8_encode($value);
  }

  /**
  *	Add more parameters to the parameter array
  *
  *	@param string $parray
  */
  public function bindMore($parray)
	{
		if(empty($this->parameters) && is_array($parray)) {
			$columns = array_keys($parray);
			foreach($columns as $i => &$column)	{
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
    $rawSqlCommand = explode(" ", $query);
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
      return $this->sQuery->fetchColumn();
    }
}
