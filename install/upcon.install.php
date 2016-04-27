<?php

// let only monstra allow to use this script
defined('MONSTRA_ACCESS') or die('No direct script access.');

// Initialize Database
Table::create(
	'upcon_persons',
	array(
		'prename',
		'lastname',
		'gender',
		'birthday',
		'email',
		'address',
		'zip',
		'city',
		'country',
		'mobile',
		'status',
		'youth',
		'safecom_visited',
		'arrival',
		'message',
		'terms_accepted',
	)
);

// Add Options
// Option::add('events_image_directory', '/');
// Option::add('events_audio_directory', '/');