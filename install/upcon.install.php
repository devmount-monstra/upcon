<?php

// let only monstra allow to use this script
defined('MONSTRA_ACCESS') or die('No direct script access.');

// Initialize Database
Table::create(
	'upcon_persons',
	array(
		'timestamp',
		'deleted',
		'upcon_id',
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
		'youthgroup',
		'safecom_visited',
		'arrival',
		'message',
		'terms_accepted',
	)
);

// Add Options
Option::add('upcon_title', '');
Option::add('upcon_id', '');
Option::add('upcon_active', 0);