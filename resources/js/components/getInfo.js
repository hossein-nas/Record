window.$ = window.jQuery = require('jquery');

export default function(){
    get_date();
    setInterval(get_date,60000);

}


(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
})();

function get_date(){

    $.ajax({
        url : '/get_info',
        type : 'POST',
        success: function(data, status, xhr){
            var info_panel = $('.info-panel');
            var weakday_name = info_panel.find('.day');
            var date = info_panel.find('.tarikh');
            var time = info_panel.find('.time');
            var trained = info_panel.find('.trained');
            var registered = info_panel.find('.registered');
            weakday_name.html(data.weakday_name);
            date.html(data.date)
            time.html( data.hour + ":" + data.minute );
            trained.html(data.todays_workout);
            registered.html(data.todays_registered);



        }
    })

}
