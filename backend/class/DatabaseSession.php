<?php
require_once 'Database.php';

class DatabaseSession extends Database {

	/** delete all expired Sessions in the database */
	public function cleanSessionTable() {
		$sqlQuery = sprintf("DELETE FROM session WHERE expiration <= NOW()");
		$this->getDb()->query($sqlQuery);
	}

	/** get a valid session by a user-id and a session-id
	*	@param		$userId			Integer
	*	@param		$sessionId		String
	*	@return		database object
	*/
	public function getValidSessionByUserIdAndSessionId($userId, $sessionId) {
		$sqlQuery = sprintf("SELECT ".$this->getRows()." FROM session WHERE user_id=%u AND session_id='%s' AND expiration > NOW()", 
							$this->escapeString($userId), $this->escapeString($sessionId));
		$result = $this->getDb()->query($sqlQuery);
		if($result->num_rows > 0) {
			return $result;
		} else {
			return null;
		}
	}

	/** check for valid session by user-id and session-id
	*	@param		$userId			Integer
	*	@param		$sessionId		String
	*	@return		Bool
	*/
	public function isValidSessionByUserIdAndSessionId($userId, $sessionId) {
		if( $this->getValidSessionByUserIdAndSessionId($userId, $sessionId) != null ) {
			return true;
		} else {
			return false;
		}
	}

	/** reset the expiration time of one session by session-id and minutes
	*	@param		$sessionId				String
	*	@param		$expirationMinutes		Integer
	*	@return		Bool
	*/
	public function resetSessionExpirationBySessionIdAndMinutes($sessionId, $expirationMinutes) {
		$sqlQuery = sprintf("UPDATE session SET expiration = NOW() + INTERVAL %u MINUTE WHERE session_id = '%s'",
							$this->escapeString($expirationMinutes), $this->escapeString($sessionId) );
		if( $this->getDb()->query($sqlQuery) ) {
			return true;
		} else {
			return false;
		}
	}

	/** check for exist of a session-id
	*	@param		$sessionId		Integer
	*	@return		Bool
	*/
	public function existSessionId($sessionId) {
		$sqlQuery = sprintf("SELECT ".$this->getRows()." FROM session WHERE session_id = '%s'", $this->escapeString($sessionId) );
		$result = $this->getDb()->query($sqlQuery);
		if($result->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	/** insert a new session-id into the database
	*	@param		$sessionId				String
	*	@param		$userId					Integer
	*	@param		$expirationMinutes		Integer
	*	@return		Bool
	*/
	public function insertNewSession($sessionId, $userId, $expirationMinutes) {
#		error_log("DatabaseSession::insertNewSession($sessionId, $userId, $expirationMinutes)");
#		echo "<br/><br/>insertNewSession<br/><br/>";
		$sqlQuery = sprintf("INSERT INTO session (session_id, user_id, expiration) VALUES('%s', %u, NOW() + INTERVAL %u MINUTE)",
							$this->escapeString($sessionId), $this->escapeString($userId), $this->escapeString($expirationMinutes) );
#		$sqlQuery = sprintf("INSERT INTO session (session_id, user_id, expiration) VALUES('$sessionId', $userId, NOW() + INTERVAL $expirationMinutes MINUTE)");
#		error_log("SQL: $sqlQuery");
		if( $this->getDb()->query($sqlQuery) ) {
#			error_log("=> TRUE");
			return true;
		} else {
#			error_log("=> FALSE");
			return false;
		}
	}
}
?>
