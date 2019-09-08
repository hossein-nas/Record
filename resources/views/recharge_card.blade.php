@extends('master_layout.master')

@section('content')
<div class="recharge_card">
    <div class="header">
        باشگاه ورزشی رکورد
        <a href="/" class="back">بازگشت</a>
    </div>
    <div class="card_reading">
        <div class="card_reading-btn">
            خواندن کارت
        </div>
    </div>
    <div class="info-panel">
        <span class="name"> </span>
        <span class="lastname"> </span>
        <span class="national_code"> </span>
        <span class="telephone"> </span>
        <span class="mobile_number"> </span>
        <span class="address"> </span>
    </div>
    <div class="action-panel">
            <form action="/recharge_card" method="POST" >
                <input type="hidden" name="uid_set" value="0" class="uid_set">
                <input type="hidden" name="uid" value="" class="uid">
                <select class="plans" name="plan">
                    @foreach( $plans as $plan)
                        <option value="{{$plan->id}}">{{ $plan->name }}</option>
                    @endforeach
                </select>
                <input type="submit" name="submit" class="submit" value="ثبت اشتراک">
            </form>
    </div>
    
</div>
@endsection()