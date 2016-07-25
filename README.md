UPcon
=====

A plugin to provide a form for registration, mail address confirmationm, registration confirmation for UPcon, a convention organized by UPdate. It's specialized on this event (e.g. the person db fields), but you can modify it for your own needs.

## Version
#### [**v1.0**](https://github.com/devmount-monstra/upcon/releases/tag/v1.0) - 2016-04-29

Here is a [list of all versions](https://github.com/devmount-monstra/upcon/releases) of `UPcon`

## Installation
1. Download latest version of `UPcon`
2. Log into Monstra backend and go to `Content > Plugins > Install new`
3. Select downloaded file and first click `Upload`, then click `Install`
5. Go to `Content > UPcon > Configuration`, set your configuration and click `Save`
6. Now everything is ready to use!

## Usage
Shortcode for content pages:

    {upcon show="registration"}

Codesnippet for templates:

    <?php UPcon::registration(); ?>

## Configuration
#### Options
| option                     | type     | description                                                                                     |
|----------------------------|----------|-------------------------------------------------------------------------------------------------|
| UPcon Title                | `string` | Title of the event (used e.g. for emails)                                                       |
| UPcon ID                   | `string` | Event ID used to assign persons to this event                                                   |
| UPcon Status               | `string` | Switch event active or inactive (not implemented atm)                                           |
| Admin email address        | `string` | Sender mail address                                                                             |
| Price normal               | `string` | Price for participants                                                                          |
| Price staff                | `string` | Price for staff members                                                                         |
| Confirmation email subject | `string` | Subject for confirmation mail                                                                   |
| Confirmation email content | `string` | Content for confirmation mail (possible markers: #NAME#, #TITLE#, #TITLE#)                      |
| Information email subject  | `string` | Subject for information mail                                                                    |
| Information email content  | `string` | Content for information mail (possible markers: #NAME#, #TITLE#, #PRICE#, #STAFF# ... #/STAFF#) |

#### Export
The list of already confirmed persons can be exported. Excel Open XML, CSV or Open Document file format can be chosen.

## License
This Plugin is distributed under [MIT-License](http://opensource.org/licenses/mit-license.html).

## Sources
[Spout](https://github.com/box/spout): a PHP library to read and write spreadsheet files (CSV, XLSX and ODS)

---
created by [devmount ![devmount logo](http://media.devmount.de/devmount_small_dark.png)](http://devmount.de)