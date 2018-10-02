<?php
include_once 'defines.php';
require_once CLASS_PATH.'Session.php';
### Session
$S = new Session();
$isLogin = false;
if( $S->isLoggedIn() === true ) { header('Location: '.INDEX_PATH.'index.php'); }
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="<?=CSS_PATH?>assignment.css" type="text/css" />
		<script type="text/javascript" src="<?=JS_PATH?>assignment.js" ></script>
		<title>NASA (3) - Register</title>
	</head>
	<body>
		<div id="container" class="container">
			<?php include 'menu.php'; ?>
			<div id="main_container" class="main-container">
				<div class="page-title"></div>
				<?php if( isset($_GET['register_fail']) && ($_GET['register_fail'] == 1) && isset($_GET['error_code'])) {
					echo "<div class=\"error message\">".$_GET['msg']." (Error-Code: ".$_GET['error_code'].")</div>";
				} ?>
				<form id="register_form" method="post" action="<?=SCRIPT_PATH?>register.php" class="login-form">
					<table>
						<tbody>
							<tr>
								<td>Username:</td>
								<td><input type="text" id="register_username" name="register_username" maxlength="10" size="30" /></td>
							</tr>
							<tr>
								<td>Password:</td>
								<td><input type="password" id="register_password_1" name="register_password_1" maxlength=50" size="30"/></td>
							</tr>
							<tr>
								<td>repeat Password:</td>
								<td><input type="password" id="register_password_2" name="register_password_2" maxlength=50" size="30"/></td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input type="submit" id="register_submit" name="register_submit" value="Register & Login" />
									<input type="reset" id="register_clear" name="register_clear" value="Clear" />
									<input type="submit" id="register_abort" name="register_abort" value="Abort" />
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</body>
</html>
