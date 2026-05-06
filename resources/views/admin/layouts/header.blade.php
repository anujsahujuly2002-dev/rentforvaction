<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

        <title>@yield('title')</title>

        <meta name="description" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @stack('meta')

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('frontend-assets/images/favicon.png')}}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
        />

        <!-- Icons. Uncomment required icon fonts -->
        <link rel="stylesheet" href="{{ asset('admin-auth-assets/vendor/fonts/boxicons.css')}}" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('admin-auth-assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('admin-auth-assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('admin-auth-assets/css/demo.css')}}" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ asset('admin-auth-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

        <link rel="stylesheet" href="{{ asset('admin-auth-assets/vendor/libs/apex-charts/apex-charts.css')}}" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    
        @stack('css')

        <!-- Page CSS -->

        <!-- Helpers -->
        <script src="{{ asset('admin-auth-assets/vendor/js/helpers.js')}}"></script>

        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ asset('admin-auth-assets/js/config.js')}}"></script>
    </head>
    <body>
        <div class="loader1 d-none" id="loader">
            <img src="{{ asset('admin-auth-assets/loader/200w.gif') }}" alt="" srcset="">
            <span>Please Wait .....</span>
         </div>
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">