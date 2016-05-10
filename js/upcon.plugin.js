/* global $ */
if (typeof $.monstra == 'undefined') $.monstra = {};

// call init
$(document).ready(function(){
    // init status constraints
    $('.upcon-staff').hide();
    $('.upcon-guest').hide();
    // set status constraints
    $('#upcon-status').change(function() {
        if ($('#upcon-status').val() == '1') {
            $('.upcon-guest').slideUp();
            $('.upcon-staff').slideUp();
        }
        if ($('#upcon-status').val() == '4') {
            $('.upcon-staff').slideDown();
            $('.upcon-guest').slideUp();
        }
        if ($('#upcon-status').val() == '5') {
            $('.upcon-guest').slideDown();
            $('.upcon-staff').slideUp();
        }
    });
});