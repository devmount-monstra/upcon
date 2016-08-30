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
        'email_confirmed',
    )
);

// Add Options
Option::add('upcon_title', '');
Option::add('upcon_id', '');
Option::add('upcon_active', 0);
Option::add('upcon_mail_confirmation', '');
Option::add('upcon_mail_confirmation_subject', '');
Option::add('upcon_mail_info', '');
Option::add('upcon_mail_info_subject', '');
Option::add('upcon_admin_mail', '');
Option::add('upcon_price_normal', '');
Option::add('upcon_price_staff', '');