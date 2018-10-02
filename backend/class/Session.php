<?php
require_once 'DatabaseSession.php';

class Session {
	private $expirationMinutes = 10;	// how long is a session valid

	function __construct() {
		session_start();
		$this->setEmptyCookie();
		DatabaseSession::cleanSessionTable();
	}

	function __destruct() { }

	/** create a empty cookie */
	private function setEmptyCookie() {
		if(ini_get("session_use_cookies")) {		// if "session_use_cookies" is set in php.ini
			$params = session_get_cookie_params();	// get contents of the cookie
			// create empty cookie
			setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
		}
	}

	/**	delete all data in the current session	*/
	private function emptySession() {
		$_SESSION = array();
	}

	/** delete the complete session */
	public function destroySession() {
		$this->generateNewSessionId();
		$this->emptySession();
		$this->setEmptyCookie();
		session_destroy();
	}

	/**	check if a user is logged in
	*	@return		Bool
	*/
	public function isLoggedIn() {
		if( (isset($_SESSION['uid'])) && (intval($_SESSION['uid'])) ) {
			$sessionId = session_id();
			$DBS = new DatabaseSession();
			$DBS->setDbColumns('session_id');
			if( $DBS->isValidSessionByUserIdAndSessionId($_SESSION['uid'], $sessionId) ) {
				$DBS->resetSessionExpirationBySessionIdAndMinutes($sessionId, $this->expirationMinutes);
				return true;
			} else {
				$this->destroySession();
				return false;
			}
		} else {
			$this->destroySession();
			return false;
		}
	}

	/**	generate a new session id
	*	@return		Bool
	*/
	public function generateNewSessionId() {
#		error_log("Session::generateNewSessionId()");
		return session_regenerate_id(true);
	}

	/**	get the current session id
	*	@return		String
	*/
	public function getSessionId() {
		return session_id();
	}

	/** check for exist of a session-id 
	*	@return		Bool
	*/
	public function existSessionIdInDb() {
		$DBS = new DatabaseSession();
		if( $DBS->existSessionId($this->getSessionId()) ) {
			return true;
		} else {
			return false;
		}
	}

	/** set user-id in session
	*	@param		$userId		Integer
	*	@retuen		Bool
	*/
	public function setSessionUserId($userId) {
		if( $this->getSessionId() != '') {
			$_SESSION['uid'] = $userId;
			return true;
		} else {
			return false;
		}
	}

	/** insert a new session into the database
	*	@param		$userId		Integer
	*	@return		Bool
	*/
	public function insertNewSessionInDb($userId) {
#		error_log("Session::insertNewSessionInDb($userId)");
		if( intval($userId) ) {
			$this->generateNewSessionId();
			$DBS = new DatabaseSession();
			if( $DBS->insertNewSession($this->getSessionId(), $userId, $this->expirationMinutes) ) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
?>
