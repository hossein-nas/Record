@extends('master_layout.master')

@section('content')
    <div class="cabinet-status">
        <div class="header">
            باشگاه ورزشی رکورد
            <a href="/" class="back">بازگشت</a>
        </div>
        

        <div class="body">
            <h3 class="title">اطلاعات کمد شماره { {{ $vars->get('cabinet_id')  }} }</h3>
            @if( $vars->get('workout') != null )
            <div class="info">
                <div class="info-line id">
                    <label for="name">کد اشتراک : </label>
                    {{ $vars->get('member')->id }}
                </div>
                <div class="info-line name">
                    <label for="name">نام : </label>
                    {{ $vars->get('member')->name . " " . $vars->get('member')->lastname }}
                </div>
                <div class="info-line entry">
                    <label for="name">ساعت ورود : </label>
                    {{ jdate($vars->get('workout')->action_at->timestamp) }}
                </div>

            </div>
            @else
            <h3 class="nodata">کمد خالی می‌باشد</h3>
            @endif
            <div class="form">

            @if ( $vars->get('workout') != null )

                <form action="/action/cabinet/{{$vars->get('workout')->cabinet_id}}/empty" method="POST" class="empty-cabinet">
                    <input type="hidden" name="workout" value="{{$vars->get('workout')->id}}">
                    <input type="submit" name="submit" value="خالی کردن کمد"></input>
                </form>
                <form action="/action/cabinet/{{$vars->get('cabinet_id')}}/open" method="POST" class="open-cabinet">
                    <input type="hidden" name="cabinet" value="{{$vars->get('cabinet_id')}}">
                    <input type="submit" name="submit" value="باز کردن کمد"></input>
                </form

            @else

                <form action="/action/cabinet/{{$vars->get('cabinet_id')}}/open" method="POST" class="open-cabinet">
                    <input type="hidden" name="cabinet" value="{{$vars->get('cabinet_id')}}">
                    <input type="submit" name="submit" value="باز کردن کمد"></input>
                </form
                
            @endif
            </div>

        </div>

    </div>
@endsection()
