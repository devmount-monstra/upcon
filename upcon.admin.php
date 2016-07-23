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

// require excel export classes
require_once 'lib/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;

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
                            UPconAdmin::export(Request::post('upcon_export'));
                            Notification::set('success', __('Excel file has been created!', 'upcon'));
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
     * @param: $type  string  [xlsx, csv, ods]
     *
     */
    private static function export($type = 'xlsx')
    {
        // check file export type
        switch ($type) {
            case 'xlsx':
            default:
                $writer = WriterFactory::create(Type::XLSX); // for XLSX files
                break;
            case 'csv':
                $writer = WriterFactory::create(Type::CSV); // for CSV files
                break;
            case 'ods':
                $writer = WriterFactory::create(Type::ODS); // for ODS files
                break;
        }

        $writer->openToBrowser('test.' . $type); // stream data directly to the browser

        // build borders
        $border = (new BorderBuilder())
            ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->build();

        // build styles
        $style_th = (new StyleBuilder())
           ->setFontBold()
           ->setFontSize(12)
           ->setFontColor(Color::rgb(110, 70, 150))
           // ->setShouldWrapText()
           ->setBorder($border)
           ->build();

        // confirmed
        $writer->addRows([['Bestätigte Personen:'],[' ']]);
        // add header for confirmed persons
        $writer->addRowWithStyle(
            [
                'Datum',
                'Vorname',
                'Nachname',
                'Geschlecht',
                'Geburtstag',
                'E-Mail',
                'Handy',
                'Adresse',
                'PLZ',
                'Stadt',
                'Land',
                'Status',
                'Jugendgruppe',
                'Sichere Gemeinde besucht',
                'Ankuft',
                'Nachricht'
            ],
            $style_th
        );
        // add rows for confirmed persons
        foreach (PersonRepository::getConfirmed() as $person) {
            $writer->addRow(
                [
                    date('d.m.Y H:i:s', $person['timestamp']),
                    $person['prename'],
                    $person['lastname'],
                    $person['gender'] == 'm' ? 'männlich' : ($person['gender'] == 'f' ? 'weiblich' : 'anderes'),
                    str_replace('-', '.', $person['birthday']),
                    $person['email'],
                    $person['mobile'],
                    $person['address'],
                    $person['zip'],
                    $person['city'],
                    $person['country'],
                    PersonRepository::statusIdToLabel($person['status']),
                    $person['youthgroup'],
                    $person['safecom_visited'] == '1' ? 'Ja' : 'Nein',
                    $person['arrival'],
                    $person['message']
                ]
            );
        }

        $writer->close();

        // prevent streaming more data
        Request::shutdown();
    }

}
