<?php

// first col4-box
$box001_1 = array(
	'id' => 'box001_1',
	'img' => 'frontend/img/presentation13_0.jpg',
	'hl1' => 'Commercial Crew',
	'hl2' => 'NASA to Name Astronauts Assigned to First Boeing, SpaceX Flights',
	'link_to_article' => null,
	'display' => 1
);
file_put_contents('box001_1.json', json_encode($box001_1));

// second col4-box
$box001_2 = array(
	'id' => 'box001_2',
	'img' => 'frontend/img/atacama_1.jpg',
	'hl1' => 'Astrobiology',
	'hl2' => 'Is Mars Soil Too Dry to Sustain Life?',
	'link_to_article' => null,
	'display' => 0
);
file_put_contents('box001_2.json', json_encode($box001_2));

// third col4-box
$box001_3 = array(
	'id' => 'box001_3',
	'img' => 'frontend/img/h-855-rwaur_illg_specta.jpg',
	'hl1' => 'Chandra X-ray',
	'hl2' => 'Chandra May Have First Evidence of a Young Star Devouring a Planet',
	'link_to_article' => null,
	'display' => 0
);
file_put_contents('box001_3.json', json_encode($box001_3));
?>
