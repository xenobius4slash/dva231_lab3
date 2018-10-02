<?php
require_once 'DatabaseArticle.php';

class Article {
	private $textDir = '../../backend/content/article/';
	private $imgDir = '';
	private $videoDir = '';
	private $article = null;

	function __construct() {}
	function __destruct() {}

	private function getTextDir() {
		return $this->textDir;
	}

	private function getImgDir() {
		return $this->imgDir;
	}

	private function getVideoDir() {
		return $this->videoDir;
	}

	/** check if an article is loaded and valid
	*	@return		Bool
	*/
	private function isArticleLoaded() {
		if($this->article === null || !is_array($this->article) ) {
			return false;
		} else {
			return true;
		}
	}

	/**	get the loaded article
	*	@return 	FALSE || Array
	*/
	public function getLoadedArticle() {
		if($this->isArticleLoaded()) {
			return $this->article;
		} else {
			return false;
		}
	}

	/** get the id of the loaded article
	*	@return		FALSE || Integer
	*/
	public function getArticleId() {
		if($this->isArticleLoaded()) {
			return $this->article['id'];
		} else {
			return false;
		}
	}

	/** get the title of the loaded article
	*	@return		FALSE || String
	*/
	public function getArticleTitle() {
		if($this->isArticleLoaded()) {
			return $this->article['title'];
		} else {
			return false;
		}
	}

	/** set the title of the loaded article
	*	@return		Bool
	*/
	public function setArticleTitle($value) {
		if($this->isArticleLoaded()) {
			$this->article['title'] = $value;
			return true;
		} else {
			return false;
		}
	}

	/** get the subtitle of the loaded article
	*	@return		FALSE || String
	*/
	public function getArticleSubtitle() {
		if($this->isArticleLoaded()) {
			return $this->article['subtitle'];
		} else {
			return false;
		}
	}

	/** set the subtitle of the loaded article
	*	@return		Bool
	*/
	public function setArticleSubtitle($value) {
		if($this->isArticleLoaded()) {
			$this->article['subtitle'] = $value;
			return true;
		} else {
			return false;
		}
	}

	/** get the text of the loaded article
	*	@return		FALSE || String
	*/
	public function getArticleText() {
		if($this->isArticleLoaded()) {
			return $this->article['text'];
		} else {
			return false;
		}
	}

	/** set the text of the loaded article
	*	@return		Bool
	*/
	public function setArticleText($value) {
		if($this->isArticleLoaded()) {
			$this->article['text'] = $value;
			return true;
		} else {
			return false;
		}
	}

	/** get the media type of the loaded article
	*	@return		FALSE || String
	*/
	public function getArticleMediaType() {
		if($this->isArticleLoaded()) {
			return $this->article['media_type'];
		} else {
			return false;
		}
	}

	/** set the media type of the loaded article
	*	@return		Bool
	*/
	public function setArticleMediaType($value) {
		if($this->isArticleLoaded()) {
			if($value == 'img' || $value == 'video') {
				$this->article['media_type'] = $value;
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/** get the media path of the loaded article
	*	@return		FALSE || String
	*/
	public function getArticleMediaPath() {
		if($this->isArticleLoaded()) {
			return $this->article['media_path'];
		} else {
			return false;
		}
	}

	/** set the media path of the loaded article
	*	@return		Bool
	*/
	public function setArticleMediaPath($value) {
		if($this->isArticleLoaded()) {
			$this->article['media_path'] = $value;
			return true;
		} else {
			return false;
		}
	}

	/** get the media size of the loaded article
	*	@return		FALSE || String
	*/
	public function getArticleMediaSize() {
		if($this->isArticleLoaded()) {
			return $this->article['media_size'];
		} else {
			return false;
		}
	}

	/** set the media size of the loaded article
	*	@return		Bool
	*/
	public function setArticleMediaSize($value) {
		if($this->isArticleLoaded()) {
			$this->article['media_size'] = $value;
			return true;
		} else {
			return false;
		}
	}

	/** get the bool for top-article of the loaded article
	*	@return		NULL || Bool
	*/
	public function getArticleTopArticle() {
		if($this->isArticleLoaded()) {
			return $this->article['top_article'];
		} else {
			return null;
		}
	}

	/** set the bool for top-article of the loaded article
	*	@return		Bool
	*/
	public function setArticleTopArticle($value) {
		if($this->isArticleLoaded()) {
			$this->article['top_article'] = $value;
			return true;
		} else {
			return false;
		}
	}

	/** get the user-id of the loaded article
	*	@return		FALSE || Integer
	*/
	public function getArticleUserId() {
		if($this->isArticleLoaded()) {
			return $this->article['user_id'];
		} else {
			return false;
		}
	}

	/** set the user-id of the loaded article
	*	@return		Bool
	*/
	public function setArticleUserId($value) {
		if($this->isArticleLoaded()) {
			$this->article['user_id'] = $value;
			return true;
		} else {
			return false;
		}
	}

	/** set the article in the class
	*	@return		Bool
	*/
	private function setLoadedArticle($article) {
		if(is_array($article)) {
			$this->article = $article;
			return true;
		} else {
			return false;
		}
	}

	/** create an empty article in the class
	*	@return 	Bool
	*/
	public function createArticle() {
		$article = array(
			'title' => null,
			'subtitle' => null,
			'text' => null,
			'media_type' => null,
			'media_path' => null,
			'media_size' => null,
			'top_article' => null
		);
		return $this->setLoadedArticle($article);
	}

	/** Check for the availability of the article
	*	@param		$id		Integer
	*	@retuen		Bool
	*/
	private function existArticleById($id) {
		// TODO: DB-Abfrage
		if( ... ) ) {
			return true;
		} else {
			return false;
		}
	}

	/** load one article
	*	@param		$id		Integer
	*	@return		Array
	*/
	public function loadArticleById($id) {
		$return = array('status' => null, 'msg' => '');
		if( !$this->existArticleById($id) ) {
			$return['status'] = false;
			$return['msg'] = 'the requested article does not exists';
		} else {
			// TODO: DB-Abfrage
			if( ... ) {
				$return['status'] = false;
				$return['msg'] = 'error while reading the database';
			} else {
				// TODO: Text aus Datei lesen
				if( ... ) {
					// TODO: DB-Array verwenden
					$this->setLoadedArticle($article);
					$return['status'] = true;
				}
			}
		}
		return $return;
	}

	public function insertLoadedArticleInDb() {
		// TODO
	}


###############################################

/*
	private function getArticleDir() {
		return $this->articleDir;
	}

	private function getArticleDirInsert() {
		return $this->articleDirInsert;
	}

	private function getArticleCountFiles() {
		return $this->articleCountFiles;
	}

	private function setArticleCountFiles($value) {
		$this->articleCountFiles = $value;
	}

	private function getArticleFullpathById($id) {
		return $this->getArticleDir()."article_$id.json";
	}

	private function getArticleFullpathByIdInsert($id) {
		return $this->getArticleDirInsert()."article_$id.json";
	}

	
	private function loadCountArticleByCountFiles() {
		$i = 0;
		foreach( glob($this->getArticleDirInsert()."article_*.json") as $filename  ) {
			$i++;
		}
		$this->setArticleCountFiles($i);
	}

*/

	/** set the title of the loaded article
	*	@return		Bool
	*/
/*
	public function setArticleId($value) {
		if($this->isArticleLoaded()) {
			$this->article['id'] = $value;
			return true;
		} else {
			return false;
		}
	}
*/

	/** write the data of the loaded article in a json file
	*	@return		Bool
	*/
/*
	public function writeLoadedArticle() {
		return file_put_contents($this->getArticleFullpathById( $this->getArticleId() ), json_encode($this->getLoadedArticle()));
	}
*/

}
?>
