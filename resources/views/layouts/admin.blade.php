<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- flag-icon-css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">
    <!-- Application Styles -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('localCSS')
    <!-- /.application-styles -->
</head>
<body class="hold-transition sidebar-mini layout-boxed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        @include('partials.admin.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('partials.admin.left-sidebar')
        <!-- /.main-sidebar-container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('flash::message')
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        @include('partials.admin.footer')
        <!-- /.footer -->

        <!-- Control Sidebar -->
        @include('partials.admin.right-sidebar')
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- Application JavaScripts -->
    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('localJavaScript')
    <!-- /.application-javascripts -->
</body>
</html>
