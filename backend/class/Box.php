<?php

class Box {
	// col4
	private $col4Dir = 'backend/content/col4/';
	private $col4DirScript = '../content/col4/';
//	private $col4FilenameRegexp = 'box001';
	private $col4Filenames = array();
	private $col4CountFiles = null;

	// pictextbox (ptb)
	private $ptbDir = 'backend/content/pictext/';
	private $ptbDirScript = '../content/pictext/';
	private $ptbFilename = 'pictextbox.json';
	private $ptbMaxTextLenght = 450;

	function __construct() {}
	function __destruct() {}

	/************
	*	col4
	*************/
	private function setCol4CountFiles($value) {
		$this->col4CountFiles = $value;
	}

	public function getCol4CountFiles() {
		return $this->col4CountFiles;
	}

	private function getCol4Dir() {
		return $this->col4Dir;
	}

	private function getCol4DirScript() {
		return $this->col4DirScript;
	}

//	private function getCol4FilenameRegexp() {
//		return $this->col4FilenameRegexp;
//	}

	/**	Load the data for all col4 (calling from index.php)
	*/
	public function loadCountAndFilenamesForCol4() {
		$i = 0;
		foreach( glob($this->getCol4Dir()."box001*.json") as $filename  ) {
			$i++;
			$this->col4Filenames[] = $filename;
		}
		$this->setCol4CountFiles($i);
	}

	/**	Load the data for all col4 (calling from admin.php)
	*/
	public function loadCountAndFilenamesForCol4Script() {
		$i = 0;
		foreach( glob($this->getCol4DirScript()."box001*.json") as $filename  ) {
			$i++;
			$this->col4Filenames[] = $filename;
		}
		$this->setCol4CountFiles($i);
	}

	/**	get the data for all col4
	*	@return		Array
	*/
	public function getCol4BoxData() {
		$array = array();
		for($i=0; $i<$this->getCol4CountFiles(); $i++) {
			$array[$i] = json_decode(file_get_contents($this->col4Filenames[$i]), true);
		}
		return $array;
	}

	/**	write the new col4 box to a new json file
	*	@param		$array			Array
	*	@param		$count			Integer		(number of box)
	*	@return		Bool
	*/
	public function writeNewCol4BoxData($array, $count) {
		$filename = 'box001_'.($count).'.json';
		return file_put_contents($this->getCol4DirScript().$filename, json_encode($array));
	}

	/**********************
	*	pictextbox
	***********************/
	private function getPtbDir() {
		return $this->ptbDir;
	}

	private function getPtbDirScript() {
		return $this->ptbDirScript;
	}

	private function getPtbFilename() {
		return $this->ptbFilename;
	}

	private function getPtbFullPath() {
		return $this->getPtbDir().$this->getPtbFilename();
	}

	private function getPtbFullPathScript() {
		return $this->getPtbDirScript().$this->getPtbFilename();
	}

	private function getPtbMaxTextLenght() {
		return $this->ptbMaxTextLenght;
	}

	/**	get the data for the pictextbox from json file (calling from the index.php)
	*	@return		Bool
	*/
	public function getPtbData() {
		return json_decode(file_get_contents($this->getPtbFullPath()), true);
	}

	/**	get the data for the pictextbox from json file (calling from the admin.php)
	*	@return		Bool
	*/
	public function getPtbDataScript() {
		return json_decode(file_get_contents($this->getPtbFullPathScript()), true);
	}

	/**	check, if the length of the text not to long.
	*	@param		$text		String
	*	@return		Bool
	*/
	private function isPtbTextLengthOk($text) {
		if(strlen($text) <= $this->getPtbMaxTextLenght() ) {
			return true;
		} else {
			return false;
		}
	}

	/** shortened the given text and add at the end "..." if it is necessary;
	*	@param		$text		String
	*	@return		String
	*/
	public function getShortenedText($text) {
		if(  $this->isPtbTextLengthOk($text) === false ) {
			return substr($text, 0, $this->getPtbMaxTextLenght() ).'...';
		} else {
			return $text;
		}
	}

	/**	write the data for the pictextbox into the json file (calling from the admin.php)
	*	@param		$array		Array
	*	@return		Bool
	*/
	public function writePtbDataScript($array) {
//		if(  $this->isPtbTextLengthOk($array['middle']) === false ) {
//			$array['middle'] = $this->getShortenedText($array['middle']);
//		} 
		return file_put_contents($this->getPtbFullPathScript(), json_encode($array));
	}
}
?>
