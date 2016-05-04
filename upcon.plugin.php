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
                // return 'test';
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
        echo '';
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

        // return view
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
        return 'error occured';
    }


}
