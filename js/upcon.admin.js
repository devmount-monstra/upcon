/* global $ */
if (typeof $.monstra == 'undefined') $.monstra = {};

$.monstra.upcon = {

    /* initialize document ready functions */
	init: function(){

        // modal: readme greybox script
        $('.readme-plugin').click(function() {
            $.ajax({
                type:'post',
                data:'readme_plugin='+$(this).attr('readme-plugin'),
                success: function(data){
                    $('#modal-documentation .modal-body').html(data);
                }
            });
        });

        // modal: person info greybox
        $('.upcon-person-info').click(function() {
            $.ajax({
                type:'post',
                data:'person_id='+$(this).attr('upcon-person'),
                dataType: 'json',
                success: function(person){
                    var dialog = $('#modal-person-info');
                    dialog.find('#person-name').text(person.prename + ' ' + person.lastname);
                    dialog.find('#upcon-person-timestamp').text(person.timestamp);
                    dialog.find('#upcon-person-upcon_id').text(person.upcon_id);
                    dialog.find('#upcon-person-prename').text(person.prename);
                    dialog.find('#upcon-person-lastname').text(person.lastname);
                    dialog.find('#upcon-person-gender').text(person.gender == 'm' ? 'male' : 'female');
                    dialog.find('#upcon-person-birthday').text(person.birthday);
                    dialog.find('#upcon-person-email').text(person.email);
                    dialog.find('#upcon-person-address').text(person.address);
                    dialog.find('#upcon-person-zip').text(person.zip);
                    // dialog.find('#upcon-person-city').text(person.city);
                    dialog.find('#upcon-person-country').text(person.country);
                    dialog.find('#upcon-person-mobile').text(person.mobile);
                    dialog.find('#upcon-person-status').text(person.status);
                    dialog.find('#upcon-person-youthgroup').text(person.youthgroup);
                    dialog.find('#upcon-person-safecom_visited').text(person.safecom_visited ? 'yes' : 'no');
                    dialog.find('#upcon-person-arrival').text(person.arrival);
                    dialog.find('#upcon-person-message').text(person.message);
                    dialog.find('#upcon-person-terms_accepted').text(person.terms_accepted ? 'yes' : 'no');
                    dialog.find('#upcon-person-email_confirmed').text(person.email_confirmed ? 'yes' : 'no');
                }
            });
        });

    }

};

// call init
$(document).ready(function(){
	$.monstra.upcon.init();
});