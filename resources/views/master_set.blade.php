@extends('master_layout.master')

@section('content')
<form action="/setMaster" method="POST" >
    <input type="text" name="master_name" placeholder="اسم مدیر را در این قسمت بنویسید">
    <input type="text" name="master_lastname" placeholder="نام خانوادگی مدیر را در این قسمت بنویسید">
    <input type="submit" name="submit" class="submit" value="ثبت">
</form>
@endsection()