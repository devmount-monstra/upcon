<?php

// let only monstra allow to use this script
defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 *	UPcon plugin admin
 *
 *  Provides forms for registration
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
        // Ajax Request: add event
        if (Request::post('edit_event_id')) {
            $upcon = new Table('upcon');
            echo json_encode($upcon->select('[id=' . Request::post('edit_event_id') . ']')[0]);
            Request::shutdown();
        }
        // Ajax Request: add category
        if (Request::post('edit_category_id')) {
            $categories = new Table('categories');
            echo json_encode($categories->select('[id=' . Request::post('edit_category_id') . ']')[0]);
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
        $categories = new Table('categories');

        // Request: add event
        if (Request::post('add_event')) {
            if (Security::check(Request::post('csrf'))) {
                $upcon->insert(
                    array(
                        'title' => (string) Request::post('event_title'),
                        'timestamp' => strtotime(Request::post('event_timestamp')),
                        'deleted' => 0,
                        'category' => (int) Request::post('event_category'),
                        'date' => (string) Request::post('event_date'),
                        'openat' => (string) Request::post('event_openat'),
                        'time' => (string) Request::post('event_time'),
                        'location' => (string) Request::post('event_location'),
                        'address' => (string) Request::post('event_address'),
                        'short' => (string) Request::post('event_short'),
                        'description' => (string) Request::post('event_description'),
                        'hashtag' => (string) Request::post('event_hashtag'),
                        'facebook' => (string) Request::post('event_facebook'),
                        'image' => (string) Request::post('event_image'),
                        'imagesection' => (string) Request::post('event_imagesection'),
                        'audio' => (string) Request::post('event_audio'),
                        'color' => (string) Request::post('event_color'),
                    )
                );
                Notification::set('success', __('Event was added with success!', 'upcon'));
                Request::redirect('index.php?id=upcon#upcon/' . UPconAdmin::eventStatus(strtotime(Request::post('event_timestamp'))) . '-upcon');
            }
            else {
                Notification::set('error', __('Request was denied. Invalid security token. Please refresh the page and try again.', 'upcon'));
                die();
            }
        }

        // Request: options
        if (Request::post('upcon_options')) {
            if (Security::check(Request::post('csrf'))) {
                Option::update('upcon_image_directory', Request::post('upcon_image_directory'));
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
            ->assign('categories', $activecategories)
            ->assign('deletedcategories', $deletedcategories)
            ->assign('categories_title', $categories_title)
            ->assign('categories_active_title', $categories_active_title)
            ->assign('categories_color', $categories_color)
            ->assign('categories_count', $categories_count)
            ->assign('upcomingupcon', $upcomingupcon)
            ->assign('pastupcon', $pastupcon)
            ->assign('deletedupcon', $deletedupcon)
            ->assign('draftupcon', $draftupcon)
            ->assign('directories', $directories)
            ->assign('files', $files)
            ->assign('path', $path)
            ->display();
    }

}
