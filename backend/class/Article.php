<?php
require_once 'DatabaseArticle.php';

class Article {
	private $textDir = '../../backend/content/article/';
	private $article = null;

	function __construct() {}
	function __destruct() {}

	private function getTextDir() {
		return $this->textDir;
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

	/** set the id of the loaded article
	*	@return		Bool
	*/
	public function setArticleId($value) {
		if($this->isArticleLoaded()) {
			$this->article['id'] = $value;
			return true;
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

	/** get the filename of the text of the loaded article
	*	@return		FALSE || String
	*/
	public function getArticleTextFilename() {
		if($this->isArticleLoaded()) {
			return $this->article['text_filename'];
		} else {
			return false;
		}
	}

	/** set the filename of the text of the loaded article
	*	@return		Bool
	*/
	public function setArticleTextFilename($value) {
		if($this->isArticleLoaded()) {
			$this->article['text_filename'] = $value;
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

	/** get the media filename of the loaded article
	*	@return		FALSE || String
	*/
	public function getArticleMediaFilename() {
		if($this->isArticleLoaded()) {
			return $this->article['media_filename'];
		} else {
			return false;
		}
	}

	/** set the media filename of the loaded article
	*	@return		Bool
	*/
	public function setArticleMediaFilename($value) {
		if($this->isArticleLoaded()) {
			$this->article['media_filename'] = $value;
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
			'id' => null,
			'title' => null,
			'subtitle' => null,
			'text' => null,
			'text_filename' => null,
			'media_type' => null,
			'media_filename' => null,
			'media_size' => null,
			'top_article' => null,
			'user_id' => null
		);
		return $this->setLoadedArticle($article);
	}

	/** Check for the availability of the article
	*	@param		$id		Integer
	*	@retuen		Bool
	*/
	private function existArticleById($id) {
		$DBA = new DatabaseArticle();
		if( $DBA->existArticleById($id) ) {
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
			$DBA = new DatabaseArticle();
			$result = $DBA->getArticleById($id);
			if( $result === false  ) {
				$return['status'] = false;
				$return['msg'] = 'error while reading the database';
			} else {
				$textFilename = $result[0]['text_filename'];
				$articleText = file_get_contents($this->getTextDir().$textFilename);
				if($articleText === false) {
					$return['status'] = false;
					$return['msg'] = 'error while reading the text from file';
				} else {
					$this->setLoadedArticle($result[0]);
					$this->setArticleText($articleText);
					$return['status'] = true;
				}
			}
		}
		return $return;
	}

	/** insert the loaded article as a new article into the database
	*	@return		FALSE || Integer (inserted article-id)
	*/
	public function insertLoadedArticleInDb() {
		$DBA = new DatabaseArticle();
		$DBA->insertNewArticle(	$this->getArticleTitle(), $this->getArticleSubtitle(), $this->getArticleTextFilename(),
								$this->getArticleMediaType(), $this->getArticleMediaFilename(), $this->getArticleMediaSize(),
								$this->getArticleTopArticle(), $this->getArticleUserId() );
	}

	/** save the text of the loaded article in a text file
	*	@return		Bool
	*/
	public function saveLoadedArticleTextToFile() {
		$filepath = $this->getTextDir().$this->getArticleTextFilename();
		return file_put_contents($this->getTextDir().$this->getArticleTextFilename(), $this->getArticleText());
	}

	/** Search for articles which match (title, subtitle) with the searchstring
	*	@param		$search			String
	*	@return		FALSE || Array
	*/
	public function searchForArticles($search) {
		$DBA = new DatabaseArticle();
		return $DBA->getSearchResultsByString($search);
	}

}
?>
