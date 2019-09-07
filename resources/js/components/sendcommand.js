window.$ = window.jQuery = require('jquery');

export default function(){
    $('.submit-btn').click(function(){
        extract_command();
    });
}

function extract_command(){
    var command = $('.form .command-box').val();
    var _data = new FormData();
    _data.append('command', command);
    console.log(_data);
    $.ajax({
        url : '/ajax_command',
        type : 'POST',
        data : {'command':command},
        success: function(data, status, xhr){
            console.log('done');
        }
    })
}