<?php

// first col4-box
$pictextbox = array(
	'media_type' => 'img',
	'media' => array(
		'img' => 'frontend/img/60th_leading_edge_of_flight_thumbnail.jpg',
		'video' => ''
	),
	'hl' => 'Countdown to Our 60th Anniversary: Trailblazing Technology',
	'middle' => "Technology drives exploration. For 60 years, we've advanced technology to meet the rigorous needs of our missions. This week, we highlight technologies developed for space which also improve your daily life on Earth.",
	'bottom' => array("Feature: NASA, 60 Years and Counting", "Video Series: Celebrating NASA's 60th Anniversary"),
	'link_to_article' => null
);
file_put_contents('pictextbox.json', json_encode($pictextbox));

?>
