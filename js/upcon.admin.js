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
                    dialog.find('#upcon-person-timestamp').text(timeConverter(person.timestamp));
                    dialog.find('#upcon-person-upcon_id').text(person.upcon_id);
                    dialog.find('#upcon-person-prename').text(person.prename);
                    dialog.find('#upcon-person-lastname').text(person.lastname);
                    dialog.find('#upcon-person-gender').text(person.gender == 'm' ? 'male' : 'female');
                    dialog.find('#upcon-person-birthday').text(person.birthday);
                    dialog.find('#upcon-person-email').text(person.email);
                    dialog.find('#upcon-person-address').text(person.address);
                    dialog.find('#upcon-person-zip').text(person.zip);
                    dialog.find('#upcon-person-city').text(person.city);
                    dialog.find('#upcon-person-country').text(person.country);
                    dialog.find('#upcon-person-mobile').text(person.mobile);
                    dialog.find('#upcon-person-status').html('<span class="label label-' + statusLabelClass(person.status) + '">' + statusConverter(person.status) + '</span>');
                    dialog.find('#upcon-person-youthgroup').text(person.youthgroup);
                    dialog.find('#upcon-person-safecom_visited').text(person.safecom_visited == '1' ? 'yes' : 'no');
                    dialog.find('#upcon-person-arrival').text(person.arrival);
                    dialog.find('#upcon-person-message').text(person.message);
                    dialog.find('#upcon-person-terms_accepted').text(person.terms_accepted == '1' ? 'yes' : 'no');
                    dialog.find('#upcon-person-email_confirmed').text(person.email_confirmed == '1' ? 'yes' : 'no');
                }
            });
        });

    }

};

// call init
$(document).ready(function(){
	$.monstra.upcon.init();
});

// helper function: timeConverter
// http://stackoverflow.com/questions/847185/convert-a-unix-timestamp-to-time-in-javascript
function timeConverter(UNIX_timestamp){
    var a = new Date(UNIX_timestamp * 1000);
    var year = a.getFullYear();
    var tempMonth = a.getMonth() + 1;
    var month = tempMonth < 10 ? '0' + tempMonth : tempMonth;
    var date = a.getDate() < 10 ? '0' + a.getDate() : a.getDate();
    var hour = a.getHours() < 10 ? '0' + a.getHours() : a.getHours();
    var min = a.getMinutes() < 10 ? '0' + a.getMinutes() : a.getMinutes();
    var sec = a.getSeconds() < 10 ? '0' + a.getSeconds() : a.getSeconds();
    var time = date + '.' + month + '.' + year + ' ' + hour + ':' + min + ':' + sec ;
    return time;
}

// helper function: statusConverter
function statusConverter(status) {
    states = {
        '1':'NORMAL',
        '2':'EARLY',
        '3':'BUJU',
        '4':'STAFF',
        '5':'VISITOR'
    };
    return states[status];
}

// helper function: statusLabelClass
function statusLabelClass(status) {
    classes = {
        '1':'default',
        '2':'warning',
        '3':'success',
        '4':'primary',
        '5':'info'
    };
    return classes[status];
}
