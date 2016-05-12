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

// register repository classes
require_once 'repositories/repository.persons.php';

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
        // // Ajax Request: add person
        // if (Request::post('edit_person_id')) {
        //     echo json_encode(EventsRepository::getById((int) Request::post('edit_person_id')));
        //     Request::shutdown();
        // }
    }

    /**
     * main upcon admin function
     */
    public static function main()
    {
        // Request: delete person
        if (Request::post('delete_person')) {
            if (Security::check(Request::post('csrf'))) {
                $id = (int) Request::post('delete_person');
                if (PersonRepository::update($id, array('deleted' => 1))) {
                    Notification::set('success', __('Person has been moved to trash with success!', 'events'));
                } else {
                    Notification::set('error', __('Table->update() returned an error. Person could not be deleted.', 'events'));
                }
                Request::redirect('index.php?id=upcon');
            }
            else {
                Notification::set('error', __('Request was denied. Invalid security token. Please refresh the page and try again.', 'events'));
                die();
            }
        }
        // handle action requests
        if (Request::get('action')) {
            switch (Request::get('action')) {
                // Request: configuration
                case "configuration":
                    // Request: options
                    if (Request::post('upcon_options_update')) {
                        if (Security::check(Request::post('csrf'))) {
                            Option::update('upcon_title', (string) Request::post('upcon_title'));
                            Option::update('upcon_id', (string) Request::post('upcon_id'));
                            Option::update('upcon_active', (int) Request::post('upcon_active'));
                            Notification::set('success', __('Configuration has been saved with success!', 'upcon'));
                            Request::redirect('index.php?id=upcon&action=configuration');
                        }
                        else {
                            Notification::set('error', __('Request was denied. Invalid security token. Please refresh the page and try again.', 'upcon'));
                            die();
                        }
                    }
                    // Display configuration view
                    View::factory('upcon/views/backend/configuration')
                        ->display();
                    break;

                // Request: statistics
                case "stats":
                    // Display statistics view
                    View::factory('upcon/views/backend/statistics')
                        ->display();
                    break;
            }
        } else {
            // Display view
            View::factory('upcon/views/backend/index')
                ->assign('persons', PersonRepository::getActive())
                ->display();
        }
    }

}
