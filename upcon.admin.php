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
// require_once 'lib/PHPExcel/Classes/PHPExcel.php';

/**
 * UPcon class
 *
 */
class UPconAdmin extends Backend
{
    /**
     * Ajax: get Event by ID
     *
     */
    public static function _getAjaxData()
    {
        // Ajax Request: add person
        if (Request::post('person_id')) {
            echo json_encode(PersonRepository::getById((int) Request::post('person_id')));
            Request::shutdown();
        }
    }

    /**
     * main upcon admin function
     *
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
                Request::redirect('index.php?id=upcon#' . PersonRepository::getMailStatus($id));
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
                            Option::update('upcon_mail_confirmation', (string) Request::post('upcon_mail_confirmation'));
                            Option::update('upcon_mail_confirmation_subject', (string) Request::post('upcon_mail_confirmation_subject'));
                            Option::update('upcon_mail_info', (string) Request::post('upcon_mail_info'));
                            Option::update('upcon_mail_info_subject', (string) Request::post('upcon_mail_info_subject'));
                            Option::update('upcon_admin_mail', (string) Request::post('upcon_admin_mail'));
                            Option::update('upcon_price_normal', (string) Request::post('upcon_price_normal'));
                            Option::update('upcon_price_staff', (string) Request::post('upcon_price_staff'));
                            Notification::set('success', __('Configuration has been saved with success!', 'upcon'));
                            Request::redirect('index.php?id=upcon&action=configuration');
                        }
                        else {
                            Notification::set('error', __('Request was denied. Invalid security token. Please refresh the page and try again.', 'upcon'));
                            die();
                        }
                    }
                    // Request: export
                    if (Request::post('upcon_export')) {
                        if (Security::check(Request::post('csrf'))) {
                            UPconAdmin::export();
                            Notification::set('success', __('Excel file has been created!', 'upcon'));
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
                ->assign('persons_pending', PersonRepository::getPending())
                ->assign('persons_confirmed', PersonRepository::getConfirmed())
                ->display();
        }
    }


    /**
     * upcon export function
     *
     */
    private static function export()
    {
        // // set excel configuration
        // PHPExcel_Settings::setLocale('de_de');
        // $excel = new PHPExcel();
        // $excel->getProperties()->setCreator('UPcon Plugin');
        // $excel->getProperties()->setLastModifiedBy('UPcon Plugin');
        // $excel->getProperties()->setTitle(Option::get('upcon_title'));
        // $excel->getProperties()->setSubject(Option::get('upcon_title'));
        // $excel->getProperties()->setDescription('Anmeldungen zu "' . Option::get('upcon_title') . '"');
        // $excel->getProperties()->setKeywords('upcon update convention');
        // $excel->getProperties()->setCategory('events');

        // // create sheet
        // $excel->createSheet();

        // // get all persons to be exported
        // $arrayData = array(
        //     array(NULL, 2010, 2011, 2012),
        //     array('Q1',   12,   15,   21),
        //     array('Q2',   56,   73,   86),
        //     array('Q3',   52,   61,   69),
        //     array('Q4',   30,   32,    0),
        // );
        // $excel->getActiveSheet()
        //     ->fromArray(
        //         $arrayData,  // The data to set
        //         NULL,        // Array values with this value will not be set
        //         'C3'         // Top left coordinate of the worksheet range where we want to set these values (default is A1)
        //     );
        // $objWriter = PHPExcel_IOFactory::createWriter($excel, "Excel2007");
        // $objWriter->save("test.xlsx");
    }

}
