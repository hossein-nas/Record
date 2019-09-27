@extends('master_layout.master')

@section('content')
    <div class="cabinet-status">
        <div class="header">
            باشگاه ورزشی رکورد
            <a href="/" class="back">بازگشت</a>
        </div>

        <div class="body">
            <h3 class="title">اطلاعات کمد شماره { {{ $workout->cabinet_id  }} }</h3>
            <div class="info">
                <div class="info-line id">
                    <label for="name">کد اشتراک : </label>
                    {{ $member->id }}
                </div>
                <div class="info-line name">
                    <label for="name">نام : </label>
                    {{ $member->name . " " . $member->lastname }}
                </div>
                <div class="info-line entry">
                    <label for="name">ساعت ورود : </label>
                    {{ jdate($workout->action_at->timestamp) }}
                </div>

            </div>
            <div class="form">
                <form action="/action/cabinet/{{$workout->cabinet_id}}/empty" method="POST">
                    <input type="hidden" name="workout" value="{{$workout->id}}">
                    <input type="submit" name="submit" value="خالی کردن کمد"></input>
                </form>
            </div>
        </div>

    </div>
@endsection()
