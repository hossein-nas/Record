window.$ = window.jQuery = require('jquery');


export default function(){
    if( $('.register_new').length > 0 ){
        var register_new_div =     $('.register_new');
        var _form = register_new_div.find('form');
        _form.on('submit', submitEvent);
        cardReadingEvent(_form.find('.card-reading') );
    }
}

function submitEvent(event){
    event.preventDefault();
    event.stopPropagation();
    var noError = true;
    var _form = $('.register_new form');

    noError &= checkforName( _form.find('.user_name') );
    noError &= checkforName( _form.find('.user_lastname') );
    noError &= checkforNationalCode( _form.find('.user_national_code') );
    noError &= checkforTelephone( _form.find('.user_telephone') );
    noError &= checkforMobileNumber( _form.find('.user_mobile_number') );
    noError &= _form.find('.uid_set').val();

    

    if( noError ){
        sendAjax(_form);
        return true;
    }
    return false;
}

function checkforName($elem){
    var $name = $elem.val();

    if ( $name.length === 0 ){
        $elem.css('border', '1px solid red');
        return false;
    }

    var regex = /[A-Za-z 0-9]{4,}/i;
    var ret = regex.test($name);
    if ( ret == false ){
        $elem.css('border', '1px solid red');
    }else{
        $elem.removeAttr('style');
    }
    return ret;
}

function checkforNationalCode($elem){
    var $name = $elem.val();

    if ( $name.length === 0 ){
        $elem.css('border', '1px solid red');
        return false;
    }

    var regex = /[0-9]{10,10}/i;
    var ret = regex.test($name);
    if ( ret == false ){
        $elem.css('border', '1px solid red');
    }else{
        $elem.removeAttr('style');
    }
    return ret;
}

function checkforTelephone($elem){
    var $name = $elem.val();

    if ( $name.length === 0 ){
        $elem.css('border', '1px solid red');
        return false;
    }

    var regex = /[0-9]{8,8}/i;
    var ret = regex.test($name);
    if ( ret == false ){
        $elem.css('border', '1px solid red');
    }else{
        $elem.removeAttr('style');
    }
    return ret;
}

function checkforMobileNumber($elem){
    var $name = $elem.val();

    if ( $name.length === 0 ){
        $elem.css('border', '1px solid red');
        return false;
    }

    var regex = /09[0-9]{9,9}/i;
    var ret = regex.test($name);
    if ( ret == false ){
        $elem.css('border', '1px solid red');
    }else{
        $elem.removeAttr('style');
    }
    return ret;
}

function cardReadingEvent($elem){

    $elem.on('click',function(){
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
                }
                else{
                    carReadingSuccess($elem,$data);   
                }
                
            }
        })
    })
}

function carReadingSuccess($elem,$data){
    $elem.unbind('click');
    var _form = $('.register_new form');
    var $uid = $data.result.substr(3);
    $elem.addClass('set').html('کارت خوانده شد.')
    _form.find('.uid_set').val(1)
    _form.find('.uid').val($uid)
}

function sendAjax($form){
    $.ajax({
        url : '/register_new',
            type : 'POST',
            data: $form.serialize(),
            success: function(_data, $status){
                if ( _data.result == 'ok'){
                    alert('ثبت نام به موفقیت انجام شد. در حال مراجعه به بخش خرید اعتبار...');
                    setTimeout(function(){
                        window.location = "http://localhost/recharge_card";
                    },1000);
                }
                else{
                    alert('کارت خوانده شده تکراری است. از کارت دیگری استفاده کنید.');
                    setTimeout(function(){
                        window.location = "http://localhost";
                    },1000);
                }
            }
    })
}