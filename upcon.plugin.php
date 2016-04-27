<?php

// let only monstra allow to use this script
defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 *	Register plugin
 *
 *  Provides forms for registration
 *
 *	@package    Monstra
 *  @subpackage Plugins
 *	@author     Andreas Müller | devmount <mail@devmount.de>
 *	@license    MIT
 *	@version    0.1.2016-01-02
 *  @link       https://github.com/devmount-monstra/register
 *
 */


// Register plugin
Plugin::register(
    __FILE__,
    __('Register'),
    __('Form registration management for Monstra.'),
    '0.1.2016-01-02',
    'devmount',
    'http://devmount.de'
);

// Include plugin admin
if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor'))) {
    Plugin::Admin('register');
}


/**
 * Add shortcode
 */
Shortcode::add('register', 'Register::_shortcode');


/**
 * Add CSS and JavaScript
 */
Action::add('theme_footer', 'Register::_insertJS');
Action::add('theme_header', 'Register::_insertCSS');


/**
 * Register class
 *
 * <code>
 *      <?php Register::show('list', 'minimal', 'future', 5, 'ASC'); ?>
 * </code>
 *
 */
class Register
{
    /**
     * Creates shortcodes for content pages
     *
     * <code>
     *      {register type="list" style="minimal" time="future" count="5" order="ASC"}
     * </code>
     *
     * @param  array $attributes given
     * @return void generated content
     *
     */
    public static function _shortcode($attributes)
    {
        switch ($attributes['type']) {
            case 'list':
                return Register::listRegister($attributes['style'], $attributes['time'], $attributes['count'], $attributes['order']);
                // return 'test';
                break;

            default:
                return Register::error();
                break;
        }
        return Register::error();
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
        echo '<link rel="stylesheet" type="text/css" href="' . Option::get('siteurl') . '/plugins/register/css/register.plugin.css" />';
    }


    /**
     * Assign to view
     */
    public function listRegister($style, $time = 'all', $count = 'all', $order = 'ASC')
    {
        // handle style
        $template = '';
        if (in_array(trim($style), array('extended', 'minimal'))) {
            $template = 'list-' . trim($style);
        } else {
            $template = 'list-minimal';
        }

        return View::factory('register/views/frontend/' . $template)
            ->assign('eventlist', Register::_getRegister($time, $count, $order))
            ->assign('categories', array(
                'color' => Register::_getCategoryAttributes('color'),
                'title' => Register::_getCategoryAttributes('title'),
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
