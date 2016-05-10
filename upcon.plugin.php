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
     * Assign to view
     *
     * @param  int     $id     of current registration set
     * @param  string  $title  of the UPcon
     */
    public function registration($id, $title)
    {
        // get db table objects
        $persons = new Table('upcon_persons');

        // TODO: Request: add person
        if (Request::post('upcon_registration_submitted')) {
            if (Security::check(Request::post('csrf'))) {
                // TODO: check requireds, dateformat, status, terms_accepted
                $persons->insert(
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
                Request::redirect(Option::get('upcon_id'));
            }
            else {
                Notification::set('error', __('Request was denied. Invalid security token. Please refresh the page and try again.', 'upcon'));
                die();
            }
        }

        // return rendered view
        return View::factory('upcon/views/frontend/registration')
            ->assign('title', $title)
            ->assign('id', $id)
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
        return 'Ooops, an error occured...';
    }


}
