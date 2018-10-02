<?php
require_once 'Database.php';

class DatabaseArticle extends Database {

	/** insert a new article into the database
	*	@param		$title			String	varchar(100)
	*	@param		$sibtitle		String	varchar(255)
	*	@param		$textPath		String	varchar(255)
	*	@param		$mediaType		String	enum('img','video')
	*	@param		$mediaPath		String	varchar(255)
	*	@param		$mediaSize		String	enum('col1','col2','col3','col4')
	*	@param		$topArticle		Bool	tinyint(1)
	*	@param		$userId			Integer	int(11)
	*	@return		FALSE || article-id
	*/
	public function insertNewArticle($title, $subtitle, $textPath, $mediaType, $mediaPath, $mediaSize, $topArticle, $userId) {
		if($topArticle === true) { $topArticle = 1; } else { $topArticle = 0; }
		$sqlQuery = sprintf("INSERT INTO article (published, title, subtitle, text_path, media_type, media_path, media_size, top_article, user_id) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', %b, %u)",
					$this->escapeString( date('Y-m-d H:i:s') ), $this->escapeString($title), $this->escapeString($subtitle), $this->escapeString($textPath), $this->escapeString($mediaType), $this->escapeString($mediaPath), 
					$this->escapeString($mediaSize), $this->escapeString($topArticle), $this->escapeString($userId) );
		if( $this->getDb()->query($sqlQuery) ) {
			return $this->getDb()->insert_id;
		} else {
			return false;
		}
	}

}
?>
