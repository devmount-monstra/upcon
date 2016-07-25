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


// Add shortcode
Shortcode::add('upcon', 'UPcon::_shortcode');

// Add CSS and JavaScript
Action::add('theme_footer', 'UPcon::_insertJS');
Action::add('theme_header', 'UPcon::_insertCSS');

// register repository classes
require_once 'repositories/repository.persons.php';


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
     *      {upcon show="registration"}
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
                return UPcon::registration();
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
                    // send mailaddress confirmation mail
                    $mail = new PHPMailer();
                    $mail->CharSet = 'UTF-8';
                    $mail->SetFrom(Option::get('upcon_admin_mail'));
                    $mail->AddReplyTo(Option::get('upcon_admin_mail'));
                    $mail->AddAddress($data['email']);
                    $mail->Subject = Option::get('upcon_title') . ': ' . Option::get('upcon_mail_confirmation_subject');
                    $mail->Body = str_replace(
                        array('#NAME#', '#TITLE#', '#LINK#'),
                        array($data['prename'] . ' ' . $data['lastname'], Option::get('upcon_title'), UPcon::buildConfirmationLink(PersonRepository::getLastId())), // generate link
                        Option::get('upcon_mail_confirmation')
                    );
                    if ($mail->Send()) {
                        Notification::set('success', __('Deine Daten wurden erfolgreich übertragen. Bitte überprüfe deinen Posteingang zur Bestätigung deiner Mailadresse!', 'upcon'));
                        Request::redirect(Page::url() . '#notifications');
                    } else {
                        Notification::setNow('error', __('Die Mail zur Bestätigung deiner Mailadresse konnte nicht versendet werden. Bitte schreib uns an ' . Option::get('upcon_admin_mail') . '!', 'upcon'));
                    }
                }
            }
            else {
                Notification::set('error', __('Die Anfrage wurde abgelehnt aufgrund eines ungültigen Sicherheitstokens. Bitte Seite neuladen und erneut probieren.', 'upcon'));
                die();
            }
        }
        // Request: confirm mail address
        if (!empty(Request::get('upcon_confirm'))) {
            // check link
            if (UPcon::emailIsConfirmed(Request::get('upcon_confirm'))) {
                // send mailaddress information mail
                list($id, $hash) = explode('-', Request::get('upcon_confirm'));
                $person = PersonRepository::getById($id);
                $mail = new PHPMailer();
                $mail->CharSet = 'UTF-8';
                $mail->SetFrom(Option::get('upcon_admin_mail'));
                $mail->AddReplyTo(Option::get('upcon_admin_mail'));
                $mail->AddAddress($person['email']);
                $mail->Subject = Option::get('upcon_title') . ': ' . Option::get('upcon_mail_info_subject');
                // replace staff markers
                $body = Option::get('upcon_mail_info');
                if ($person['status'] == UPcon::STATUS_STAFF) {
                    $body = str_replace(array('#STAFF#', '#/STAFF#'), '', $body);
                } else {
                    $body = UPcon::deleteAllBetween('#STAFF#', '#/STAFF#', $body);
                }
                $mail->Body = str_replace(
                    array('#NAME#', '#TITLE#', '#PRICE#'),
                    array($person['prename'] . ' ' . $person['lastname'], Option::get('upcon_title'), $person['status'] == UPcon::STATUS_STAFF ? Option::get('upcon_price_staff') : Option::get('upcon_price_normal')), // generate link
                    $body
                );
                // add attachment depending on age
                if (UPcon::validateAge($person['birthday'])) {
                    $mail->AddAttachment(UPLOADS . '/upcon/teilnehmererklaerung.pdf');
                } else {
                    $mail->AddAttachment(UPLOADS . '/upcon/teilnehmererklaerung_minderjaehrig.pdf');
                }
                $mail->Send();
                Notification::set('success', __('Deine Mailadresse wurde erfolgreich bestätigt! Du hast jetzt eine Mail mit allen notwendigen Informationen zu deiner UPcon Anmeldung erhalten.', 'events'));
                Request::redirect(Page::url() . '#notifications');
            } else {
                Notification::setNow('error', __('Deine Mailadresse konnte nicht bestätigt werden oder wurde bereits bestätigt. Bitte kontaktiere einen Admin unter ' . Option::get('upcon_admin_mail') . '!', 'events'));
            }
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
                'o' => __('anderes', 'upcon'),
            ))
            ->assign('status', array(
                UPcon::STATUS_NORMAL => __('TeilnehmerIn', 'upcon'),
                // UPcon::STATUS_EARLY => __('Frühbucher', 'upcon'),
                // UPcon::STATUS_BUJU => __('BUJU', 'upcon'),
                UPcon::STATUS_STAFF => __('MitarbeiterIn', 'upcon'),
                UPcon::STATUS_VISITOR => __('Tagesgast', 'upcon'),
            ))
            ->render();
    }


    /**
     * error occurance
     *
     */
    public function error()
    {
        return 'Ups, es gab einen Fehler...';
    }


    /**
     * status labels
     *
     * @param integer $state to convert
     *
     * @return string status label
     *
     */
    public static function statusLabel($state)
    {
        switch ($state) {
            case UPcon::STATUS_NORMAL:
                return 'NORMAL';
                break;
            case UPcon::STATUS_EARLY:
                return 'EARLY';
                break;
            case UPcon::STATUS_BUJU:
                return 'BUJU';
                break;
            case UPcon::STATUS_STAFF:
                return 'STAFF';
                break;
            case UPcon::STATUS_VISITOR:
                return 'VISITOR';
                break;
            default:
                return '';
                break;
        }
    }


    /**
     * status label classes
     *
     * @param integer $state to convert
     *
     * @return string status label class
     *
     */
    public static function statusLabelClass($state)
    {
        switch ($state) {
            case UPcon::STATUS_NORMAL:
                return 'default';
                break;
            case UPcon::STATUS_EARLY:
                return 'warning';
                break;
            case UPcon::STATUS_BUJU:
                return 'success';
                break;
            case UPcon::STATUS_STAFF:
                return 'primary';
                break;
            case UPcon::STATUS_VISITOR:
                return 'info';
                break;
            default:
                return '';
                break;
        }
    }


    /**
     * builds a link to confirm email address
     *
     * @param integer $id of person
     *
     * @return string link url
     *
     */
    public static function buildConfirmationLink($id)
    {
        $person = PersonRepository::getById($id);
        $hash = md5($person['timestamp'] . $person['lastname'] . $person['birthday']);
        $link = Page::url() . '?upcon_confirm=' . $id . '-' . $hash;
        return $link;
    }


    /**
     * checks a link to confirm email address
     *
     * @param string $hash of clicked link
     *
     * @return boolean
     *
     */
    public static function emailIsConfirmed($hash)
    {
        list($id, $md5hash) = explode('-', $hash);
        $person = PersonRepository::getById($id);
        if (md5($person['timestamp'] . $person['lastname'] . $person['birthday']) == $md5hash) {
            PersonRepository::update($id, array('email_confirmed' => 1));
            return true;
        } else {
            return false;
        }
    }


    /**
     * validate birthday
     *
     * @param  string  $birthday date
     * @param  integer $age      to validate
     *
     * @return boolean           older than age: true
     *
     */
    function validateAge($birthday, $age = 18)
    {
        // $birthday can be UNIX_TIMESTAMP or just a string-date.
        if(is_string($birthday)) {
            $birthday = strtotime($birthday);
        }

        // check
        // 31536000 is the number of seconds in a 365 days year.
        if(time() - $birthday < $age * 31536000)  {
            return false;
        }

        return true;
    }


    /**
     * returns string between two delimiters
     * http://www.justin-cook.com/wp/2006/03/31/php-parse-a-string-between-two-strings/
     *
     * @param  string $start  tag
     * @param  string $end    tag
     * @param  string $string full string
     *
     * @return string         text between delimiter
     *
     */
    function getStringBetween($start, $end, $string)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }


    /**
     * delete all between two delimiters
     * http://stackoverflow.com/questions/13031250/php-function-to-delete-all-between-certain-characters-in-string
     *
     * @param  string $start  tag
     * @param  string $end    tag
     * @param  string $string full string
     *
     * @return string         text without content between delimiters
     *
     */
    function deleteAllBetween($start, $end, $string)
    {
        $beginningPos = strpos($string, $start);
        $endPos = strpos($string, $end);
        if ($beginningPos === false || $endPos === false) {
            return $string;
        }
        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);
        return str_replace($textToDelete, '', $string);
    }
}
