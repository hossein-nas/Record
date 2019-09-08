@extends('master_layout.master')

@section('content')
<div class="register_new">
    <div class="header">
        باشگاه ورزشی رکورد
        <a href="/" class="back">بازگشت</a>
    </div>
    <form action="/register_new" method="POST" >
        <input type="hidden" name="uid_set" value="0" class="uid_set">
        <input type="hidden" name="uid" value="" class="uid">
        <div class="textgroup">
            <label for="name">نام: </label>
            <input type="text" name="user_name" class="user_name" autocomplete="off">
        </div>
        <div class="textgroup">
            <label for="name">نام خانوادگی: </label>
            <input type="text" name="user_lastname" class="user_lastname" autocomplete="off">
        </div>
        <div class="textgroup">
            <label for="name">کد ملی: </label>
            <input type="text" name="user_national_code" class="user_national_code" autocomplete="off">
        </div>
        <div class="textgroup">
            <label for="name">تلفن ثابت: </label>
            <input type="text" name="user_telephone" class="user_telephone" autocomplete="off">
        </div>
        <div class="textareagroup">
            <label for="name">آدرس: </label>
            <textarea name="user_address" class="user_address" >تهران - شهرقدس - </textarea>
        </div>
        <div class="textgroup">
            <label for="name">تلفن همراه: </label>
            <input type="text" name="user_mobile_number" class="user_mobile_number" autocomplete="off">
        </div>
        
        <div class="actionarea">
            <div class="card-reading">
                خواندن کارت
            </div>
            <input type="submit" name="submit" class="submit" value="ثبت">
        </div>
    </form>
</div>
@endsection()