window.$ = window.jQuery = require('jquery');

var init = 0;
var $data = null;

export default function(){
    getCabinetInfo();
}

function getCabinetInfo(){

    $.ajax({
        url : '/cabinet_info',
        type : 'POST',
        data: {
            'init' : true
        },
        success: function(_data, $status){
            $data = JSON.parse(_data);
            init = 1;
            setTimeout(getCabinetInfo,5000);
            manageHTML($data);
        }
    })

}

function manageHTML($data){
    var cabinets_div = $('.cabinets');
    var updated_nodes = $("<div class='row'>");
    $data.map(function(_data, _in){
        var section  = $("<section>").addClass('cabinet');
        if ( _data.status ==1 ){
            var elem = $("<label for='number'>").addClass('active').html(_data.cabinet_no);
            section.append( elem );
            section.click(function(){
                window.location.href = '/info/cabinet/' + _data.cabinet_no;
            })
        }
        else{
            section.append( $("<label for='number'>").html(_data.cabinet_no));
        }
        updated_nodes.append(section);
    })
    cabinets_div.html(updated_nodes);
}

