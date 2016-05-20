<?php

// let only monstra allow to use this script
defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 *	UPcon plugin
 *
 *  A plugin to provide a form for registration, mail address confirmationm,
 *  registration confirmation for UPcon, a convention organized by UPdate.
 *
 *	@package    Monstra
 *  @subpackage Plugins
 *	@author     Andreas Müller | devmount <mail@devmount.de>
 *	@license    MIT
 *	@version    1.0
 *  @link       https://github.com/devmount-monstra/upcon
 *
 */


// UPcon plugin
Plugin::register(
    __FILE__,
    __('UPcon', 'upcon'),
    __('Form registration for UPcon events.', 'upcon'),
    '1.0',
    'devmount',
    'http://devmount.de'
);

// Include plugin admin
if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor'))) {
    Plugin::Admin('upcon');
}


/**
 * Add shortcode
 */
Shortcode::add('upcon', 'UPcon::_shortcode');


/**
 * Add CSS and JavaScript
 */
Action::add('theme_footer', 'UPcon::_insertJS');
Action::add('theme_header', 'UPcon::_insertCSS');


/**
 * UPcon class
 *
 * <code>
 *      <?php UPcon::show('list', 'minimal', 'future', 5, 'ASC'); ?>
 * </code>
 *
 */
class UPcon
{
    /**
     * Participant status: Normal
     *
     * @var integer
     */
    const STATUS_NORMAL = 1;

    /**
     * Participant status: Early
     *
     * @var integer
     */
    const STATUS_EARLY = 2;

    /**
     * Participant status: Buju
     *
     * @var integer
     */
    const STATUS_BUJU = 3;

    /**
     * Participant status: Staff
     *
     * @var integer
     */
    const STATUS_STAFF = 4;

    /**
     * Participant status: Visitor
     *
     * @var integer
     */
    const STATUS_VISITOR = 5;


    /**
     * Creates shortcodes for content pages
     *
     * <code>
     *      {upcon show="registration" title="UPcon 2016" id="upcon16"}
     * </code>
     *
     * @param  array $attributes given
     * @return void generated content
     *
     */
    public static function _shortcode($attributes)
    {
        switch ($attributes['show']) {
            case 'registration':
                return UPcon::registration($attributes['id'], $attributes['title']);
                break;

            default:
                return UPcon::error();
                break;
        }
        return UPcon::error();
    }


    /**
     * _insertJS function
     *
     * @return JavaScript to insert
     *
     */
    public static function _insertJS()
    {
        echo '<script src="' . Option::get('siteurl') . '/plugins/upcon/js/upcon.plugin.js"></script>';
    }


    /**
     * _insertCSS function
     *
     * @return JavaScript to insert
     *
     */
    public static function _insertCSS()
    {
        echo '<link rel="stylesheet" type="text/css" href="' . Option::get('siteurl') . '/plugins/upcon/css/upcon.plugin.css" />';
    }


    /**
     * Registration formula view
     *
     */
    public function registration()
    {
        // get db table objects
        $persons = new Table('upcon_persons');

        // get data
        $data = array(
            'prename' => Request::post('prename'),
            'lastname' => Request::post('lastname'),
            'gender' => Request::post('gender'),
            'birthday_d' => Request::post('birthday_d'),
            'birthday_m' => Request::post('birthday_m'),
            'birthday_y' => Request::post('birthday_y'),
            'email' => Request::post('email'),
            'address' => Request::post('address'),
            'zip' => Request::post('zip'),
            'city' => Request::post('city'),
            'country' => Request::post('country'),
            'mobile' => Request::post('mobile'),
            'status' => Request::post('status'),
            'youthgroup' => Request::post('youthgroup'),
            'safecom_visited' => Request::post('safecom_visited'),
            'arrival' => Request::post('arrival'),
            'message' => Request::post('message'),
            'terms_accepted' => Request::post('terms_accepted'),
        );
        $data = array_map('trim', $data);

        // Request: register person
        if (Request::post('upcon_registration_submitted')) {
            if (Security::check(Request::post('csrf'))) {
                // check requireds
                if (
                    !$data['prename'] or
                    !$data['lastname'] or
                    !$data['gender'] or
                    !$data['birthday_d'] or
                    !$data['birthday_m'] or
                    !$data['birthday_y'] or
                    !$data['email'] or
                    !$data['address'] or
                    !$data['city'] or
                    !$data['country'] or
                    !$data['status']
                ) {
                    Notification::setNow('error', __('Es wurden nicht alle Pflichtfelder (*) ausgefüllt. Deine Daten wurden noch nicht gespeichert.', 'upcon'));
                } else
                // check terms accepted
                if (!Request::post('terms_accepted')) {
                    Notification::setNow('error', __('AGB und Datenschutzbedingungen müssen akzeptiert werden!', 'upcon'));
                } else {
                    // insert person if all checks passed
                    $persons->insert(
                        array(
                            'timestamp' => time(),
                            'deleted' => 0,
                            'upcon_id' => (string) Option::get('upcon_id'),
                            'prename' => (string) $data['prename'],
                            'lastname' => (string) $data['lastname'],
                            'gender' => (string) $data['gender'],
                            'birthday' => sprintf("%02d", $data['birthday_d']) . '-' . sprintf("%02d", $data['birthday_m']) . '-' . $data['birthday_y'],
                            'email' => (string) $data['email'],
                            'address' => (string) $data['address'],
                            'zip' => (string) $data['zip'],
                            'city' => (string) $data['city'],
                            'country' => (string) $data['country'],
                            'mobile' => (string) $data['mobile'],
                            'status' => (int) $data['status'],
                            'youthgroup' => (string) $data['youthgroup'],
                            'safecom_visited' => (int) $data['safecom_visited'],
                            'arrival' => (string) $data['arrival'],
                            'message' => (string) $data['message'],
                            'terms_accepted' => (int) $data['terms_accepted'],
                            'email_confirmed' => 0,
                        )
                    );
                    // TODO: send mailaddress confirmation mail
                    Notification::set('success', __('Deine Daten wurden erfolgreich übertragen. Bitte überprüfe deinen Posteingang zur Bestätigung deiner Mailadresse!', 'upcon'));
                    Request::redirect(Page::url());
                }
            }
            else {
                Notification::set('error', __('Die Anfrage wurde abgelehnt aufgrund eines ungültigen Sicherheitstokens. Bitte Seite neuladen und erneut probieren.', 'upcon'));
                die();
            }
        }

        // TODO: Request: confirm mail address
        if (Request::get('upcon_confirm_mail')) {

        }

        // return registration view
        return View::factory('upcon/views/frontend/registration')
            ->assign('data', $data)
            ->assign('decision', array(
                0 => __('Nein', 'upcon'),
                1 => __('Ja', 'upcon'),
            ))
            ->assign('gender', array(
                'f' => __('weiblich', 'upcon'),
                'm' => __('männlich', 'upcon'),
            ))
            ->assign('status', array(
                UPcon::STATUS_NORMAL => __('Teilnehmer', 'upcon'),
                // UPcon::STATUS_EARLY => __('Frühbucher', 'upcon'),
                // UPcon::STATUS_BUJU => __('BUJU', 'upcon'),
                UPcon::STATUS_STAFF => __('Mitarbeiter', 'upcon'),
                UPcon::STATUS_VISITOR => __('Tagesgast', 'upcon'),
            ))
            ->render();
    }


    /**
     * error occurance
     */
    public function error()
    {
        return 'Ups, es gab einen Fehler...';
    }


}
