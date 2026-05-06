<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{env('APP_NAME')}} | </title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend-assets/images/favicon.png') }}">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('frontend-assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <!--Custom CSS-->
    <link href="{{ asset('frontend-assets/css/hotel.css') }}" rel="stylesheet" type="text/css">
    <!--Flaticons CSS-->
    <link href="{{ asset('frontend-assets/font/flaticon.css') }}" rel="stylesheet" type="text/css">
    <!--Plugin CSS-->
    <link href="{{ asset('frontend-assets/css/plugin.css') }}" rel="stylesheet" type="text/css">
    <!--Custom CSS-->
    <link href="{{ asset('frontend-assets/css/custom.css') }}" rel="stylesheet" type="text/css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Litepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css" />
    {{-- bootstrap-datepicker css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
    {{-- toaster css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    @stack('css')
    @yield('css1')
</head>
<body>
    <div class="loading" style="display: none">Please Wait &#8230;</div>
