@extends('master_layout.master')

@section('content')
<div class="register_new">
    <div class="header">
        باشگاه ورزشی رکورد
    </div>
    <form action="/setMaster" method="POST" >
        <div class="textgroup">
            <label for="name">نام: </label>
            <input type="text" name="user_name" class="user_name">
        </div>
        <div class="textgroup">
            <label for="name">نام خانوادگی: </label>
            <input type="text" name="user_lastname" class="user_lastname">
        </div>
        <div class="textgroup">
            <label for="name">کد ملی: </label>
            <input type="text" name="user_national_code" class="user_national_code">
        </div>
        <div class="textgroup">
            <label for="name">تلفن ثابت: </label>
            <input type="text" name="user_telephone" class="user_telephone">
        </div>
        <div class="textareagroup">
            <label for="name">آدرس: </label>
            <textarea name="user_address" class="user_address" ></textarea>
        </div>
        <div class="textgroup">
            <label for="name">تلفن همراه: </label>
            <input type="text" name="user_mobile_number" class="user_mobile_number">
        </div>
        
        <input type="submit" name="submit" class="submit" value="ثبت">
    </form>
</div>
@endsection()