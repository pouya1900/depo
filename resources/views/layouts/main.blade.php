<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token()  }}">
    <base href="{{env('APP_URL')}}">
    <title>دپو راهوار</title>

    <link href="storage/plugins/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="storage/plugins/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="storage/plugins/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="storage/css/jquery.dataTables.css" rel="stylesheet">
    <script type="text/javascript" src="storage/js/jquery-3.6.0.min.js"></script>
    @yield('head')

    <link rel="stylesheet"
          href="storage/css/bootstrap.rtl.min.css">

    <link href="storage/css/style.css" rel="stylesheet">


</head>
<body>

<div class="main_container">
    <div class="row full-height full-width">
        @include('partials.sidebar')

        @yield('content')
    </div>
</div>

<script type="text/javascript" src="storage/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="storage/js/jquery.dataTables.js"></script>

@yield('script')

</body>
</html>
