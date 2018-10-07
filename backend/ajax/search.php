<?php
#error_log("ajax/search.php");
require_once 'defines.php';
require_once CLASS_PATH.'Article.php';

if( isset($_POST['search']) ) {
#	error_log("ajax/search.php => isset => TRUE");
	$return = array('status' => null, 'msg' => null, 'data' => null);
	$search = htmlspecialchars($_POST['search']);
#	error_log("ajax/search.php => isset => TRUE => search: '$search'");
	$ART = new Article();
	$result = $ART->searchForArticles($search);

	if($result === false) {
		$return['status'] = false;
		$return['msg'] = 'Internal error';
	} else {
		if(count($result) == 0) {
			$return['status'] = false;
			$return['msg'] = 'no match';
		} else {
			$return['status'] = true;
			$return['data'] = $result;
//			echo "<pre>"; print_r($result); echo "</pre>";
		}
	}

	echo json_encode($return);
}
?>
