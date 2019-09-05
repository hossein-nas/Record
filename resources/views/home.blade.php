@extends('master_layout.master')

@section('content')
<div class="container">
    <div class="main-section">
        <div class="info-panel">
            <p>امروز</p>
            <h3 class="date">
                <span class="day">
                    چهارشنبه
                </span>
                <span class="tarikh">
                    98/11/27
                </span>
            </h3>
            <p>ساعت</p>
            <h3 class="time">
                16:24
            </h3>
            <div class="trained">
120
            </div>
            <div class="registered">
                4
            </div>

        </div>
        <div class="action-panel">
            <div class="register-btn">
                ثبت نام جديد
            </div>
            <div class="recharge-btn">
                تمديد اشتراک
            </div>
            <div class="list-users">
                مشاهده کاربران
            </div>

        </div>
        <div class="log-panel">

            <form action="" class='form'>
                <input type="text" name='command' class="command-box">
                <input type="button" class="submit-btn" name='submit' value="ارسال">
            </form>
        </div>

    </div>
    <div class="cabinets">
        <div class="row">
            <section class="cabinet">
                <label for="number">1</label>

            </section>
            <section class="cabinet">
                <label for="number">2</label>

            </section>
            <section class="cabinet">
                <label for="number">3</label>

            </section>
            <section class="cabinet">
                <label for="number">4</label>

            </section>
            <section class="cabinet">
                <label for="number">5</label>

            </section>
            <section class="cabinet">
                <label for="number">6</label>

            </section>
            <section class="cabinet">
                <label for="number">7</label>

            </section>
            <section class="cabinet">
                <label for="number">8</label>

            </section>
            <section class="cabinet">
                <label for="number">9</label>

            </section>
            <section class="cabinet">
                <label for="number">10</label>

            </section>
        </div>
        <div class="row"></div>

    </div>
</div>
@endsection