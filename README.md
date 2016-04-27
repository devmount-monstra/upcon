UPcon
=====

A plugin to provide a form for registration, mail address confirmationm, registration confirmation for UPcon, a convention organized by UPdate.

## Installation
1. Download latest version of `UPcon`
2. Log into Monstra backend and go to `Content > Plugins > Install new`
3. Select downloaded file and first click `Upload`, then click `Install`
5. Go to `Content > UPcon > Configuration`, set your configuration and click `Save`
6. Now everything is ready to use!

## Frontend
Shortcode for content pages:

    {upcon type="..." time="..." order="..."}

Codesnippet for templates:

    <?php upcon::show(<...>, <...>); ?>

## Configuration

| field           | description                                                                                                  |
|-----------------|--------------------------------------------------------------------------------------------------------------|
| Image directory | directory for event images. Those images will be displayed in the select list of the upcon add/edit formula. |
  
## License
This Plugin is distributed under [MIT-License](http://opensource.org/licenses/mit-license.html).

## Sources
This plugin is developed by [devmount](http://devmount.de).