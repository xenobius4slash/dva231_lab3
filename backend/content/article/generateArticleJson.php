<?php
$article = array(
	'id' => '',
	'title' => '',
	'subtitle' => '',
	'text' => '',
	'media_type' => '',
	'media_path' => ''
);
file_put_contents('article_1.json', json_encode($article));
?>
