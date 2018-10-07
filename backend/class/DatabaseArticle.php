<?php
require_once 'Database.php';

class DatabaseArticle extends Database {

	/** insert a new article into the database
	*	@param		$title				String	varchar(100)
	*	@param		$subtitle			String	varchar(255)
	*	@param		$textFilename		String	varchar(255)
	*	@param		$mediaType			String	enum('img','video')
	*	@param		$mediaFilename		String	varchar(255)
	*	@param		$mediaSize			String	enum('col1','col2','col3','col4')
	*	@param		$topArticle			Bool	tinyint(1)
	*	@param		$userId				Integer	int(11)
	*	@return		FALSE || article-id
	*/
	public function insertNewArticle($title, $subtitle, $textFilename, $mediaType, $mediaFilename, $mediaSize, $topArticle, $userId) {
		if($topArticle === true || $topArticle == 1) { $topArticle = 1; } else { $topArticle = 0; }
		$sqlQuery = sprintf("INSERT INTO article (published, title, subtitle, text_filename, media_type, media_filename, media_size, top_article, user_id) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', %b, %u)",
					$this->escapeString( date('Y-m-d H:i:s') ), $this->escapeString($title), $this->escapeString($subtitle), $this->escapeString($textFilename), $this->escapeString($mediaType), $this->escapeString($mediaFilename), 
					$this->escapeString($mediaSize), $this->escapeString($topArticle), $this->escapeString($userId) );
		if( $this->getDb()->query($sqlQuery) ) {
			return $this->getDb()->insert_id;
		} else {
			return false;
		}
	}

	/** return all tuples which match with the searchstring in the title or subtitle
	*	@param		$search			String
	*	@return		FALSE || Array
	*/
	public function getSearchResultsByString($search) {
#		error_log("DatabaseArticle::getSearchResultsByString($search)");
		$sqlQuery = sprintf("SELECT id, CONCAT(title, ' - ' ,subtitle) AS title_subtitle FROM article 
							WHERE LOWER(title) LIKE LOWER('%%%s%%') OR LOWER(subtitle) LIKE LOWER('%%%s%%')",
							$this->escapeString($search), $this->escapeString($search));
		$result = $this->getDb()->query($sqlQuery);
		if( $result ) {
			return $this->getArrayFromSqlResult($result);
		} else {
			return false;
		}
	}

	/** return one tuple by the article-id
	*	@param		$articleId		Integer
	*	@return		FALSE || Array
	*/
	public function getArticleById($articleId) {
		$sqlQuery = sprintf("SELECT * FROM article WHERE id = %u", $this->escapeString($articleId));
		$result = $this->getDb()->query($sqlQuery);
		if( $result ) {
			return $this->getArrayFromSqlResult($result);
		} else {
			return false;
		}
	}

	/**	check for exist of the article
	*	@param		$articleId		Integer
	*	@return		Bool
	*/
	public function existArticleById($articleId) {
		$sqlQuery = sprintf("SELECT COUNT(*) FROM article WHERE id = %u", $this->escapeString($articleId));
		$result = $this->getDb()->query($sqlQuery);
		if( $result->num_rows == 1 ) {
			return true;
		} else {
			return false;
		}
	}

}
?>
