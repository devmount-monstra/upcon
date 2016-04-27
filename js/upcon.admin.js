/* global $ */
if (typeof $.monstra == 'undefined') $.monstra = {};

$.monstra.register = {

    /* initialize document ready functions */
	init: function(){
        // activate current tab on page reload
        $.monstra.register.handleTabLinks();

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

    }

};

// call init
$(document).ready(function(){
	$.monstra.register.init();
});