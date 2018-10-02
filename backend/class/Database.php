<?php
require_once CONFIG_PATH.'mysql_login.inc.php';

class Database {
	private $db;
	private $rows = '*';

	/** create the connection with the database and set the charset to "utf8"
	*/
	function __construct() {
#		error_log("Database::__construct()");
		$this->db =  mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_BASE);
		if( mysqli_connect_errno() ) { 
			error_log("Failed to connect to MySQL: (" . mysqli_connect_errno() . ") " . mysqli_connect_error()); 
		} else {
#			error_log("Database connection established.");
			if (!$this->db->set_charset("utf8")) {
				error_log("Error loading character set utf8: ". $this->db->error);
			} 
#			else { error_log("Current character set: ". $this->db->character_set_name() ); }
		}
	}

	/** close the connection to the database
	*/
	function __destruct() {
#		error_log("Database conection closed.");
		mysqli_close($this->db);
	}

	public function getDb() {
		return $this->db;
	}

	public function getRows() {
		return $this->rows;
	}

	/** get a masked string for the database query
	*	@param		$string		String
	*	@return		String
	*/
	public function escapeString($string) {
		return mysqli_real_escape_string($this->db, $string);
	}

	/** set rows of a database query
	*	@param		$stringRows		String
	*/
	public function setDbColumns($stringRows) {
		if($stringRows != '') {
			$this->rows = $stringRows;
		}
	}

	/**	set the the rows to the default (all => *) for the database query
	*/
	public function resetDbColumns() {
		$this->rows = '*';
	}

	/** create and get an assoc array from a database result
	*	@param		$result		Database result object
	*	@return		Array
	*/
	public function getArrayFromSqlResult($result) {
		$resultArray = array();
		while ($row = $result->fetch_assoc()) {
			$resultArray[] = $row;
		}
		return $resultArray;
	}

	/** create and get an assoc array from one special line of the result
	*	the target line is controled throug the parameter "row", default of "row" is the 0, so the first line.
	*	@param		$result		Database result object
	*	@param		$row		Integer (default: 0)
	*	@return		Array
	*/
	public function getOneRowArrayFromSqlResult($result, $row=0) {
		$result->data_seek($row);
		return $result->fetch_assoc();
	}
}

?>
