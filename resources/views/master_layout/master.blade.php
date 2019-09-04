<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/app.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('styles')
    <title>باشگاه رکورد</title>
</head>
<body>
    @yield('content')
   
   <script src="{{ mix('js/vendor.js') }}" type="text/javascript" charset="utf-8" async defer></script>
   <script src='./js/app.js'></script> 

    @yield('scripts')
</body>
</html>