@extends('master_layout.master')

@section('content')
    <div class="manage-users">
        <div class="header">
            باشگاه ورزشی رکورد
            <a href="/" class="back">بازگشت</a>
        </div>
        

        <div class="body">
            <div class="search-area">
                <div class="input-area">
                    <div class="input-group">
                        <label for="">نام : </label>
                        <input type="text" name="username" class="username"> 
                    </div>
                    <div class="input-group">
                        <label for="">کد ملی : </label>
                        <input type="text" name="national_code" class="national_code">
                    </div>
                </div>
                <div class="search-btn">جستجو</div>
            </div>
            <div class="users-list">
                <div class="user-item">
                    <span class="id">
                        #173
                    </span>
                    <div class="info">
                        <span class="username">HOSSEIN NASIRI</span>
                        <div>
                            (کد ملی: 
                            <span class="national-code">1680174266</span>
                            )
                        </div>
                        <a href="#" class="edit">مشاهده</a>
                    </div>
                </div>
            </div>
            <div class="details">
                <div class="pagination">
                    <div class="prev">
                        <a href="#">قبلی</a>
                    </div>
                    <div class="current">
                        صفحه(
                            <span class="current-page">1</span>
                        )
                    </div>
                    <div class="next">
                        <a href="#">بعدی</a>
                    </div>

                </div>
                <div class="info">
                    <span>
                        کل صفحات (
                            <span class="all-pages">4</span>
                        )
                    </span> | 
                    <span>
                        کل اعضا(
                            <span class="all-members">44</span>
                        )
                    </span> 
                </div>
            </div>

        </div>

    </div>
@endsection()
