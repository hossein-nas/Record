@extends('master_layout.master')

@section('content')
    <div class="user-info-page">
        <div class="header">
            باشگاه ورزشی رکورد
            <a href="/manage/users" class="back">بازگشت</a>
        </div>
        

        <div class="body">
            <div class="title">
                <div class="username">
                    اطلاعات کاربر {
                    <span>{{ $member->name . " " . $member->lastname }} </span>
                    }
                </div>
                <div class="remaining-days">
                    {{ $remaining_days }}

                </div>
            </div>
            <div class="user-info">
                <div class="national-code">
                    کد ملی :
                    <span>{{ $member->national_code }}</span>
                </div>
                <div class="mobile-number">
                    شماره تماس :
                    <span>{{ $member->mobile_number  }}</span>
                </div>
                <div class="address">
                    آدرس :
                    <span>{{ $member->address }}</span>
                </div>
            </div>
            <div class="actions">
                <a href="/user/{{$member->id}}/edit" class="edit-user">ویرایش کاربر</a>
            </div>

        </div>

    </div>
@endsection()
