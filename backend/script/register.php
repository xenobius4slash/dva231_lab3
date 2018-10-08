<?php
include_once 'defines.php';
require_once CLASS_PATH.'Session.php';
require_once CLASS_PATH.'User.php';

if( isset($_POST['register_submit']) ) {
	$error = array('code' => null, 'msg' => null);
	$username = htmlspecialchars($_POST['register_username']);
	$password1 = htmlspecialchars($_POST['register_password_1']);
	$password2 = htmlspecialchars($_POST['register_password_2']);
	$registerError = false;

	$U = new User();
	if( !$U->isValidUsername($username) ) {
		$error['code'] = 1;
		$error['msg'] = 'No valid Username';
		$registerError = true;
	} else{
		if( $U->existUserByUsername($username) ) {
			$error['code'] = 2;
			$error['msg'] = 'The username already exists';
			$registerError = true;
		} else {
			if( (!$U->isValidPassword($password1)) || (!$U->isValidPassword($password2)) ) {
				$error['code'] = 3;
				$error['msg'] = 'No valid password';
				$registerError = true;
			} else {
				if($password1 != $password2) {
					$error['code'] = 4;
					$error['msg'] = 'The compare of passwords failed';
					$registerError = true;
				} else {
					if( !$U->insertNewUserInDb($username, $password1) ) {
						// ERROR: error while inserting the new user in the database
						$error['code'] = 5;
						$error['msg'] = 'Internal error #3';
						$registerError = true;
					} else {
						$userId = $U->getUserIdByUsername($username);
						$S = new Session();
						if( !$S->insertNewSessionInDb($userId) ) {
							// ERROR: error while inserting the new session in the database
							$error['code'] = 6;
							$error['msg'] = 'Internal error #4';
							$registerError = true;
						} else {
							if( !$S->setSessionUserId($userId) ) {
								// ERROR: error while adding user-id in session (session doesn't exist)
								$error['code'] = 7;
								$error['msg'] = 'Internal error #5';
								$registerError = true;
							}
						}
					}
				}
			}
		}
	}
	if($error['code'] == null && $registerError === true) {
		header('Location: '.INDEX_PATH.'index.php');
	} else {
		header('Location: '.HTML_PATH.'register.php?register_fail=1&error_code='.$error['code'].'&msg='.$error['msg']);
	}
}
?>
