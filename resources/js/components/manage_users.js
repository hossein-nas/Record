window.$ = window.jQuery = require('jquery');

export default function () {
    var $manage_users = $('.manage-users').get();
    if ($manage_users.length > 0) { // this makes sure that we are in manage-user page :)
        getInitialData();

    }

}


// util functions

function getInitialData() {
    $.ajax({
        url: '/users/1/page',
        type: 'POST',
        success: function (data, $status) {
            var $data = JSON.parse(data);
            if ($data.result == 'ok') {
                manageItemHtml($data.data.all_users)
                managePagination($data.data);
            }
            else {
                console.log('khata');
            }


        }
    })

}

function getDataByPage($page) {

}

function manageItemHtml($users) {
    var $len = $users.length;
    var users_list = $('.manage-users .body .users-list');
    var new_list = $('');
    users_list.empty();

    for (var i = 0; i < $len; i++) {

        var temp = $('<div class="user-item"> \
    <span class="id"> \
        #173 \
    </span> \
    <div class="info"> \
        <span class="username">HOSSEIN NASIRI</span> \
        <div> \
            (کد ملی: \
            <span class="national-code">1680174266</span> \
            ) \
        </div> \
        <a href="#" class="edit">مشاهده</a> \
    </div> \
</div>');
        var name = $users[i].name + " " + $users[i].lastname;
        var national_code = $users[i].national_code;
        var id = $users[i].id;
        temp.find('.id').html('#' + id);
        temp.find('.username').html(name);
        temp.find('.national-code').html(national_code);
        temp.find('.edit').attr('href', '/user/' + id + '/info');
        users_list.append(temp);
    }


}

function managePagination($data) {
    var details_elem = $('.manage-users .body .details');
    details_elem.empty();
    var all_users = $data.count;

    var all_pages = $data.pages;
    var next_page = $data.next_page;
    var prev_page = $data.prev_page;
    var current_page = $data.current_page;
    var template = $('<div class="pagination"> \
                    <div class="prev"> \
                        <a href="#">قبلی</a> \
                    </div> \
                    <div class="current"> \
                        صفحه( \
                            <span class="current-page">1</span> \
                        ) \
                    </div> \
                    <div class="next"> \
                        <a href="#">بعدی</a> \
                    </div> \
 \
                </div> \
                <div class="info"> \
                    <span> \
                        کل صفحات ( \
                            <span class="all-pages">4</span> \
                        ) \
                    </span> |  \
                    <span> \
                        کل اعضا( \
                            <span class="all-members">44</span> \
                        ) \
                    </span>  \
                </div>');


    if (prev_page == null) {
        template.find('.prev').html('');
    }
    else {
        var prev_elem = $('<span> قبلی </span>');
        managePageButtons(prev_elem, prev_page);
        template.find('.prev').html(prev_elem)
    }

    if (next_page == null) {
        template.find('.next').html('');
    }
    else {
        var next_elem = $('<span> بعدی </span>');
        managePageButtons(next_elem, next_page);
        template.find('.next').html(next_elem)
    }

    template.find('.current-page').html(current_page);
    template.find('.all-members').html(all_users);
    template.find('.all-pages').html(all_pages);
    details_elem.html(template);
}


function managePageButtons($elem, $page) {
    $elem.click(function () {
        $.ajax({
            url: '/users/' + $page + '/page',
            type: 'POST',
            success: function (data, $status) {
                var $data = JSON.parse(data);
                if ($data.result == 'ok') {
                    manageItemHtml($data.data.all_users)
                    managePagination($data.data);
                }
                else {
                    console.log('khata');
                }
            }
        })
    })

}