<?php
require_once 'defines.php';
require_once CLASS_PATH.'Box.php';
require_once CLASS_PATH.'Article.php';

if( isset($_POST['send_news']) ) {
	$error = array('title' => 0, 'subtitle' => 0, 'text' => 0, 'media_type' => 0, 'file_upload' => array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0) );
	$isError = false;
	$title = htmlspecialchars($_POST['title']);
	$subtitle = htmlspecialchars($_POST['subtitle']);
	$text = htmlspecialchars($_POST['text']);
	$mediaType = htmlspecialchars($_POST['media_type']); $errorMediaType = false;
	if( $mediaType != 'img' && $mediaType != 'video' ) { $errorMediaType = true; }

	if($title == '') { $error['title'] = 1; $isError = true; }
	if($subtitle == '') { $error['subtitle'] = 1; $isError = true; }
	if($text == '') { $error['text'] = 1; $isError = true; }

	if($isError === true) {
		error_log("[upload] There are one or more empty element(s).");
		header('Location: '.HTML_PATH.'admin.php?error='.json_encode($error));
	} else {

		$arrayFileType = array( 'img' => array("jpg", "jpeg", "png", "gif"), 'video' => array("mp4", "ogv", "ogg", "avi", "flv") );
		if($errorMediaType === true) {
			$error['media_type'] = true;
			error_log("[upload] No media type was selected.");
			header('Location: '.HTML_PATH.'admin.php?upload_ok=0&error='.json_encode($error));
		} else {
			// check allowed file type
			$errorFoundFileType = true;
			$filename = basename($_FILES["file_upload"]["name"]);
			$fileType = strtolower(pathinfo($filename , PATHINFO_EXTENSION));
			if(array_search(strtolower($fileType), $arrayFileType) !== false) {
				$error['file_upload'][1] = 1;
				header('Location: '.HTML_PATH.'admin.php?upload_ok=0&error='.json_encode($error));
				error_log("[upload] Wrong file type, only JPG, JPEG, PNG, GIF, MP4, OGV, OGG, AVI, FLV are allowed.");
			} else {
				if($mediaType == 'img') { 
					$uploadDir = IMG_PATH; 
					$jsonDir = 'frontend/img/';		// TODO: raus lassen?
					if( array_search(strtolower($fileType), $arrayFileType['img']) !== false) { $errorFoundFileType = false; }
				} elseif($mediaType == 'video') { 
					$uploadDir = VIDEO_PATH; 
					$jsonDir = 'frontend/video/';	// TODO: raus lassen?
					if( array_search(strtolower($fileType), $arrayFileType['video']) !== false ) { $errorFoundFileType = false; }
				}
				var_dump($errorFoundFileType);
				if($errorFoundFileType === true ) {
					error_log("[upload] Wrong file type for $mediaType."); 
					$error['file_upload'][1] = 2;
					header('Location: '.HTML_PATH.'admin.php?upload_ok=0&error='.json_encode($error));
				} else {
					$fullFilepath = $uploadDir . uniqid('', true).'.'.strtolower($fileType);
					if(file_exists($fullFilepath)) {
						error_log("[upload] The file already exists.");
						$error['file_upload'][2] = 1;
						header('Location: '.HTML_PATH.'admin.php?upload_ok=0&error='.json_encode($error));
					} else {
						$maxFileSize = substr(ini_get('upload_max_filesize'), 0, -1) * 1024 * 1024;
						if ($_FILES["file_upload"]["size"] > $maxFileSize  ) {
							error_log("[upload] The file is too large.");
							$error['file_upload'][3] = 1;
							header('Location: '.HTML_PATH.'admin.php?upload_ok=0&error='.json_encode($error));
						} else {
							if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $fullFilepath)) {
								error_log("[upload] Upload complete ". basename( $_FILES["file_upload"]["name"]) );

								/** create the box and article contents **/

								// article
								$textArray = explode("\n", $text);
								$textArticle = '';
								foreach($textArray as $line) {
									$textArticle .= trim($line);
									$textArticle .= "<br/>";
								}
								$textArticle = rtrim($textArticle, '<br/>');
								
								$ART = new Article();
								$ART->createArticle();
								$articleId = $ART->getArticleId();
	//							echo "article old<pre>"; print_r($ART->getLoadedArticle()); echo "</pre>";
								$ART->setArticleId($articleId);
								$ART->setArticleTitle($title);
								$ART->setArticleSubtitle($subtitle);
								$ART->setArticleText($textArticle);
								$ART->setArticleMediaType($mediaType);
								$ART->setArticleMediaPath($jsonDir.basename( $_FILES["file_upload"]["name"]));
	//							echo "article new<pre>"; print_r($ART->getLoadedArticle()); echo "</pre>";
								$ART->writeLoadedArticle();

								$BOX = new Box();

								// pic-text-box
								$arrayPtb = $BOX->getPtbDataScript();
	//							echo "ptb old<pre>"; print_r($arrayPtb); echo "</pre>";
								$arrayPtb['media_type'] = $mediaType;
								$arrayPtb['media']['img'] = '';
								$arrayPtb['media']['video'] = '';
								if($mediaType == 'img') { 
									$arrayPtb['media']['img'] = $jsonDir.basename( $_FILES["file_upload"]["name"]);
								} elseif($mediaType == 'video') {
									$arrayPtb['media']['video'] = $jsonDir.basename( $_FILES["file_upload"]["name"]);
								}
								$arrayPtb['hl'] = $title;
								$arrayPtb['middle'] = $BOX->getShortenedText($text);
								$arrayPtb['bottom'] = array();
								$arrayPtb['link_to_article'] = $articleId;
	//							echo "ptb new<pre>"; print_r($arrayPtb); echo "</pre>";
								$BOX->writePtbDataScript($arrayPtb);

								// col4 box
								$BOX->loadCountAndFilenamesForCol4Script();
								$countCol4 = $BOX->getCol4CountFiles();
	//							echo "Count Filename: $countCol4<br/>";
								$col4Img = '';
								if($mediaType == 'img') { $col4Img = $arrayPtb['media']['img'];	}
								$arrayCol4 = array(	'id' => 'box001_'.($countCol4+1), 'img' => $col4Img, 'hl1' => $title, 'hl2' => $subtitle, 'link_to_article' => $articleId, 'display' => 0	);
	//							echo "col4 new<pre>"; print_r($arrayCol4); echo "</pre>";
								$BOX->writeNewCol4BoxData($arrayCol4, ($countCol4+1));

								header('Location: ../../frontend/html/admin.php?upload_ok=1');
							} else {
								error_log("[upload] Internal error.");
								$error['file_upload'][4] = 1;
								header('Location: ../../frontend/html/admin.php?upload_ok=0&error='.json_encode($error));
							}
						}
					}
				}
			} 
		}
	}
}
?>
