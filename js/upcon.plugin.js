/* global $ */
if (typeof $.monstra == 'undefined') $.monstra = {};

// call init
$(document).ready(function(){
    // init status constraints
    $('.upcon-staff').hide();
    $('.upcon-guest').hide();
    toggleStatusFields();
    // toggle fields on status change
    $('#upcon-status').change(function() {
        toggleStatusFields();
    });
});

function toggleStatusFields() {
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
}