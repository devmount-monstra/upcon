UPcon
=====

A plugin to provide a form for registration, mail address confirmationm, registration confirmation for UPcon, a convention organized by UPdate.

## Version
#### [**v1.0**](https://github.com/devmount-monstra/upcon/releases/tag/v1.0) - 2016-04-29

Here is a [list of all releases](https://github.com/devmount-monstra/upcon/releases) of `UPcon`

## Installation
1. Download latest version of `UPcon`
2. Log into Monstra backend and go to `Content > Plugins > Install new`
3. Select downloaded file and first click `Upload`, then click `Install`
5. Go to `Content > UPcon > Configuration`, set your configuration and click `Save`
6. Now everything is ready to use!

## Usage
Shortcode for content pages:

    {upcon show="registration" title="UPcon 2016" id="upcon16"}

Codesnippet for templates:

    <?php UPcon::registration('The answer to life, the universe and everything?', '42'); ?>

## Options
| option         | type     | description                                                 |
|----------------|----------|-------------------------------------------------------------|
| Slide duration | `int`    | How many milliseconds the sliding animation should take     |
| Slide easing   | `string` | Easing type for the sliding animation: `swing` or `linear`  |

## License
This Plugin is distributed under [MIT-License](http://opensource.org/licenses/mit-license.html).

## Sources
No external sources in use.

---
created by [devmount ![devmount logo](http://media.devmount.de/devmount_small_dark.png)](http://devmount.de)