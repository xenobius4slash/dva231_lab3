<?php
require_once 'defines.php';
require_once CLASS_PATH.'Article.php';
require_once CLASS_PATH.'Session.php';

if( isset($_POST['send_news']) ) {
	$error = array('title' => 0, 'subtitle' => 0, 'text' => 0, 'media_type' => 0, 'media_type' => 0, 'file_upload' => array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0) );
	$isError = false;
	$topArticle = htmlspecialchars($_POST['top_article']);
	$title = htmlspecialchars($_POST['title']);
	$subtitle = htmlspecialchars($_POST['subtitle']);
	$text = htmlspecialchars($_POST['text']);
	$mediaType = htmlspecialchars($_POST['media_type']); $errorMediaType = false;
	if( $mediaType != 'img' && $mediaType != 'video' ) { $errorMediaType = true; }
	$mediaSize = htmlspecialchars($_POST['media_size']); $errorMediaSize = false;
	if( !intval($mediaSize) || $mediaSize < 1 || $mediaSize > 4 ) { $errorMediaSize = true; }

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
			if($errorMediaSize === true) {
				$error['media_size'] = true;
				error_log("[upload] No media size was selected.");
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
						if( array_search(strtolower($fileType), $arrayFileType['img']) !== false) { $errorFoundFileType = false; }
					} elseif($mediaType == 'video') { 
						$uploadDir = VIDEO_PATH; 
						if( array_search(strtolower($fileType), $arrayFileType['video']) !== false ) { $errorFoundFileType = false; }
					}
					if($errorFoundFileType === true ) {
						error_log("[upload] Wrong file type for $mediaType."); 
						$error['file_upload'][1] = 2;
						header('Location: '.HTML_PATH.'admin.php?upload_ok=0&error='.json_encode($error));
					} else {
						$generatedFilename = uniqid('', true);
						$filenameMedia = $generatedFilename.'.'.strtolower($fileType);
						$filenameText = $generatedFilename.'.txt';
						$fullFilepath = $uploadDir . $filenameMedia;
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
#									error_log("[upload] Upload complete ". basename( $_FILES["file_upload"]["name"]) );

									$S = new Session();
									if( !$S->isLoggedIn() ) {
										error_log("[admin] user is not logged in.");
										header('Location: '.INDEX_PATH.'index.php');
									} else {
										$userId = $S->getSessionUserId();

										// article text
										$textArray = explode("\n", $text);
										$textArticle = '';
										foreach($textArray as $line) {
											$textArticle .= trim($line);
											$textArticle .= "<br/>";
										}
										$textArticle = rtrim($textArticle, '<br/>');
									

										/** create an article and save in the datatabse **/
										$ART = new Article();
										$ART->createArticle();
#										echo "article old<pre>"; print_r($ART->getLoadedArticle()); echo "</pre>";
										$ART->setArticleTitle($title);
										$ART->setArticleSubtitle($subtitle);
										$ART->setArticleText($textArticle);
										$ART->setArticleTextFilename($filenameText);
										$ART->setArticleMediaType($mediaType);
										$ART->setArticleMediaFilename($filenameMedia);
										$ART->setArticleMediaSize('col'.$mediaSize);
										$ART->setArticleTopArticle($topArticle);
										$ART->setArticleUserId($userId);
#										echo "article new<pre>"; print_r($ART->getLoadedArticle()); echo "</pre>";
										$ART->insertLoadedArticleInDb();

										// save the article text of the loaded article to a file
										$ART->saveLoadedArticleTextToFile();										
		
										header('Location: '.HTML_PATH.'admin.php?upload_ok=1');
									}
								} else {
									error_log("[upload] Internal error.");
									$error['file_upload'][4] = 1;
									header('Location: '.HTML_PATH.'admin.php?upload_ok=0&error='.json_encode($error));
								}
							}
						}
					}
				} 
			}
		}
	}
}
?>
