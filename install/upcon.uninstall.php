<?php

// let only monstra allow to use this script
defined('MONSTRA_ACCESS') or die('No direct script access.');

// drop db tables
Table::drop('upcon_persons');

// Delete Options
Option::delete('upcon_title');
Option::delete('upcon_id');
Option::delete('upcon_active');