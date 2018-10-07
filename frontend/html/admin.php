<?php
include_once 'defines.php';
require_once CLASS_PATH.'Session.php';
### Session
$S = new Session();
$isLogin = false;
if( $S->isLoggedIn() === true ) { $isLogin = true; }  else { header('Location: '.INDEX_PATH.'index.php'); }
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="<?=CSS_PATH?>assignment.css" type="text/css" />
		<script type="text/javascript" src="<?=JS_PATH?>assignment.js" ></script>
		<title>NASA (3) - Admin</title>
	</head>
	<body>
		<div id="container" class="container">
			<?php include 'menu.php'; ?>
			<div id="main_container" class="main-container">
				<div class="page-title"></div>
				<div class="message">
					<?php $err = false; $fontCol = "style=\"color: red; font-weight: bold;\"";
						if(isset($_GET['error']) ) {
							$error = json_decode($_GET['error'], true);
							if($error['title']==1 || $error['subtitle']==1 || $error['text']==1) {
								$err = true;
								echo "<span class=\"error\">There are one or more empty element(s).</span>";
							}
						}
						if(isset($_GET['upload_ok'])) {
							if( $_GET['upload_ok'] == 0 ) {
								$err = true;
								$error = json_decode($_GET['error'], true);
								if($error['file_upload'][1] == 1 ) { echo "<span class=\"error\">Wrong file type, only JPG, JPEG, PNG, GIF, MP4, OGV, OGG, AVI, FLV are allowed.</span>"; }
								if($error['file_upload'][1] == 2 ) { echo "<span class=\"error\">Wrong file type for the choosed media type.</span>"; }
								elseif($error['file_upload'][2] == 1 ) { echo "<span class=\"error\">The file already exists.</span>"; }
								elseif($error['file_upload'][3] == 1 ) { echo "<span class=\"error\">The file is too large.</span>"; }
								elseif($error['file_upload'][4] == 1 ) { echo "<span class=\"error\">Internal error.</span>"; }
								elseif($error['file_upload'][5] == 1 ) { echo "<span class=\"error\">No media type was selected.</span>"; }
							} 
							else { echo "<span class=\"success\">Upload complete.</span>"; }
						}
					?>
				</div>
				<form id="form_admin" class="form-admin" method="post" action="<?=SCRIPT_PATH?>admin.php" enctype="multipart/form-data">
					<div>
						<h3>Add a new article into the database.</h3>
						<br/><br/>
					</div>
					<table>
						<tr>
							<td><span <?=($err && $error['top_article']==1)?($fontCol):('')?>>Top article:</span></td>
							<td>
								<input type="radio" id="top_article_no" name="top_article" value="0" checked="checked" /> no
								&nbsp;&nbsp;&nbsp;
								<input type="radio" id="top_article_yes" name="top_article" value="1" /> yes
							</td>
						</tr>
						<tr>
							<td><span <?=($err && $error['title']==1)?($fontCol):('')?>>Title:</span></td>
							<td><input type="text" id="title" name="title" maxlength="100"  size="100" /></td>
						</tr>
						<tr>
							<td><span <?=($err && $error['subtitle']==1)?($fontCol):('')?>>Subtitle:</span></td>
							<td><input type="text" id="subtitle" name="subtitle"  maxlength="255" size="100" /></td>
						</tr>
						<tr>
							<td><span <?=($err && $error['text']==1)?($fontCol):('')?>>Text:</span></td>
							<td><textarea id="text" name="text" rows="4" cols="100"></textarea></td>
						</tr>
						<tr>
							<td><span <?=($err && $error['media_type']==1)?($fontCol):('')?>>Media type:</span></td>
							<td>
								<input type="radio" id="mdia_type_img" name="media_type" value="img" checked="checked" onclick="selectRadioImg()"/> image
								&nbsp;&nbsp;&nbsp;
								<input type="radio" id="media_type_video" name="media_type" value="video" onclick="selectRadioVideo()" /> video
							</td>
						</tr>
						<tr>
							<td><span <?=($err && $error['media_size']==1)?($fontCol):('')?>>Media size:</span></td>
							<td>
								<input type="radio" id="mdia_size_col1" name="media_size" value="1" checked="checked" /> 1 column
								&nbsp;&nbsp;&nbsp;
								<input type="radio" id="mdia_size_col2" name="media_size" value="2" /> 2 column
								&nbsp;&nbsp;&nbsp;
								<input type="radio" id="mdia_size_col3" name="media_size" value="3" /> 3 column
								&nbsp;&nbsp;&nbsp;
								<input type="radio" id="mdia_size_col4" name="media_size" value="4" /> 4 column
							</td>
						</tr>
						<tr>
							<td>select file:</td>
							<td>
								<input type="file" id="file_upload" name="file_upload" accept=".jpg,.jpeg,.png,.gif"> 
								<small>(max. <?=ini_get('upload_max_filesize')?>)</small></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="submit" id="send_news" name="send_news" value="save" />
								&nbsp;
								<input type="reset" id="clear_form" name="clear_form" value="clear" />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</body>
</html>
