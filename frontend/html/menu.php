<script type="text/javascript" src="<?=JS_PATH?>jquery.min.js"></script>
<script type="text/javascript" src="<?=JS_PATH?>search.js"></script>
<div id="menu_container" class="menu-container">
	<a href="<?=INDEX_PATH?>index.php">
		<div id="menu_logo" class="nasa-logo">
			<div class="fake">FAKE</div>
			<img src="<?=IMG_PATH?>nasa-logo.svg" />
		</div>
	</a>
	<div id="menu_main">
		<table class="table-menu-main">
			<tr>
				<td>Missions</td>
				<td>Galleries</td>
				<td>NASA TV</td>
				<td>Follow NASA</td>
				<td>Downloads</td>
				<td>About</td>
				<td>NASA Audiences</td>
				<td>
					<div class="search">
						<input id="search_input" type="text" placeholder="Search" />
						<span id="icon-connect" class="icon-connect"></span>
						<input type="hidden" id="index_bool" value="<?=(INDEX_PATH=='')?('1'):('0')?>" />
						<div id="search_result" class="search-result"></div>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div id="menu_sub" class="div-menu-sub">
		<table class="table-menu-sub">
			<tr>
				<td>International Space Station</td>
				<td>Journey to Mars</td>
				<td>Earth</td>
				<td>Technology</td>
				<td>Aeronautics</td>
				<td>Solar System and Beyond</td>
				<td>Education</td>
				<td>History</td>
				<td>Benefits to You</td>
			</tr>
		</table>
		<div class="login-button">
			<?php if($isLogin) {
				echo "<a href=\"".HTML_PATH."admin.php\"><input type=\"button\" value=\"Admin\" /></a>";
				echo "&nbsp;";
				echo "<a href=\"".INDEX_PATH."index.php?logout=1\"><input type=\"button\" value=\"Logout\" /></a>";
			} else {
				echo "<a href=\"".HTML_PATH."login.php\"><input type=\"button\" value=\"Login\" /></a>";
			} ?>
		</div>
	</div>
</div>
