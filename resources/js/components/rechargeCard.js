window.$ = window.jQuery = require('jquery');


export default function(){
    if( $('.recharge_card').length > 0 ){
        fetchData();
        $('.submit').on('click', submitForm );
    }
}


function fetchData(){
    $('.recharge_card .card_reading .card_reading-btn').on('click', function(){
        fetchUID();
    })

}

function fetchUID(){
    $.ajax({
        url : '/ajax_command',
        type : 'POST',
        data: {
            'command' : "#NEWCARD"
        },
        success: function(_data, $status){
            var $data = JSON.parse(_data);
            if ($data.result == "NOT DETECTED."){
                alert('کارت خوانده نشد دوباره تلاش کنید.');
                return false;
            }
            else{
                return extractData($data);
            }

        }
    })
}

function extractData($data){
    var $uid = $data.result.substr(3);
    var _form = $(".recharge_card .action-panel form");
    _form.find('.uid_set').val('1');
    _form.find('.uid').val($uid);
    $.ajax({
        url : '/get_card_info',
        type : 'POST',
        data: {
            'uid' : $uid
        },
        success: function(_data, $status){
            var $data = JSON.parse(_data);
            if ( $data.result == 'error'){
                alert('کارت نا معتبر است');
            }
            else if ( $data.result == 'ok'){
                var name = $data.data.member.name + " " + $data.data.member.lastname;
                $('.recharge_card .info-panel .name').html(name);
                $('.recharge_card .info-panel .address').html($data.data.member.address);
                $('.recharge_card .info-panel .national_code').html($data.data.member.national_code);
                $('.recharge_card .info-panel .telephone').html($data.data.member.telephone);
                $('.recharge_card .info-panel .mobile_number').html($data.data.member.mobile_number);
                $('.recharge_card .info-panel .remain_days').html($data.data.remaining_days);

                // displaying plan area
                $('.recharge_card .action-panel').addClass('active');
            }
        }
    })
}

function submitForm(e){
    var _form = $(".recharge_card .action-panel form");

    e.stopPropagation();
    e.preventDefault();

    if( _form.find('uid_set').val()  == '0'){
        alert('کارت به درستی خوانده شده است');
        return;
    }

    $.ajax({
        url : '/recharge_card',
        type : 'POST',
        data: _form.serialize() ,
        success: function(_data, $status){
            var $data = JSON.parse(_data);
            if ($data.result == 'ok' ){
                alert('کارت با موفقیت تمدید شد');
                window.location = '/';
            }
            else if ( $data.result == 'active_plan' ){
                alert('کاربر مورد نظر دارای اعتبار است و نیازی به تمدید نیست');
            }
            else{
                alert('خطایی رخ داد. دوباره تلاش کنید.')
            }
        }
    })



    return false;
}
