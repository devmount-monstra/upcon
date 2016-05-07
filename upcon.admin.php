<?php

// let only monstra allow to use this script
defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 *	UPcon plugin admin
 *
 *  Provides a list of all registered records and some statistics
 *
 *	@package    Monstra
 *  @subpackage Plugins
 *	@author     Andreas Müller | devmount <mail@devmount.de>
 *	@license    MIT
 *  @link       https://github.com/devmount-monstra/upcon
 *
 */

// Add plugin styles and scripts
Stylesheet::add('plugins/upcon/css/upcon.admin.css', 'backend', 11);
Javascript::add('plugins/upcon/js/upcon.admin.js', 'backend', 11);

// Admin Navigation: add new item
Navigation::add(__('UPcon', 'upcon'), 'content', 'upcon', 10);

// Add action on admin_pre_render hook
Action::add('admin_pre_render','UPconAdmin::_getAjaxData');

/**
 * UPcon class
 *
 */
class UPconAdmin extends Backend
{
    /**
     * Ajax: get Event by ID
     */
    public static function _getAjaxData()
    {
        // Ajax Request: edit person
        if (Request::post('edit_person_id')) {
            $upcon = new Table('upcon_persons');
            echo json_encode($upcon->select('[id=' . Request::post('edit_person_id') . ']')[0]);
            Request::shutdown();
        }
    }

    /**
     * main upcon admin function
     */
    public static function main()
    {
        // get db table objects
        $upcon = new Table('upcon');

        // Request: add person
        if (Request::post('add_person')) {
            if (Security::check(Request::post('csrf'))) {
                $upcon->insert(
                    array(
                        'timestamp' => time(),
                        'deleted' => 0,
                        'upcon_id' => (string) Option::get('upcon_id'),
                        'prename' => (string) Request::post('prename'),
                        'lastname' => (string) Request::post('lastname'),
                        'gender' => (string) Request::post('gender'),
                        'birthday' => (string) Request::post('birthday'),
                        'email' => (string) Request::post('email'),
                        'address' => (string) Request::post('address'),
                        'zip' => (string) Request::post('zip'),
                        'city' => (string) Request::post('city'),
                        'country' => (string) Request::post('country'),
                        'mobile' => (string) Request::post('mobile'),
                        'status' => (int) Request::post('status'),
                        'youthgroup' => (string) Request::post('youthgroup'),
                        'safecom_visited' => (int) Request::post('safecom_visited'),
                        'arrival' => (string) Request::post('arrival'),
                        'message' => (string) Request::post('message'),
                        'terms_accepted' => (int) Request::post('terms_accepted'),
                    )
                );
                Notification::set('success', __('Person was added with success!', 'upcon'));
                Request::redirect('index.php?id=upcon');
            }
            else {
                Notification::set('error', __('Request was denied. Invalid security token. Please refresh the page and try again.', 'upcon'));
                die();
            }
        }

        // Request: options
        if (Request::post('upcon_options')) {
            if (Security::check(Request::post('csrf'))) {
                Option::update('upcon_title', Request::post('upcon_title'));
                Option::update('upcon_id', Request::post('upcon_id'));
                Option::update('upcon_active', Request::post('upcon_active'));
                Notification::set('success', __('Configuration has been saved with success!', 'upcon'));
                Request::redirect('index.php?id=upcon#configuration');
            }
            else {
                Notification::set('error', __('Request was denied. Invalid security token. Please refresh the page and try again.', 'upcon'));
                die();
            }
        }

        // Display view
        View::factory('upcon/views/backend/index')
            ->assign('persons', $upcon->select('all'))
            ->display();
    }

}
