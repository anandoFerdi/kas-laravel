<!doctype html>
<html>
<head>
    <title>Dashboad KasLaravel</title>
</head>
<body>

    @include('layouts.header')
    @include('layouts.sidebar')
    @include('layouts.topbar')
    @yield('content')
    @include('layouts.footer')
</body>
</html>
