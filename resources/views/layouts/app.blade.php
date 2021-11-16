<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    @stack('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title', 'Bundesliga Tippspiel')</title>
    <link rel="icon" type="image/vnd.microsoft.icon" href="{{ asset('images/logo.png') }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" />
    @stack('style')
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <x-layout.top-nav />
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <x-layout.side-nav />
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">{{ __('messages.sidebar.loggedInAs') }}</div>
                <div>{{ Auth::user()->name }}</div>
                <div class="small">Gruppe: <a href="#" data-toggle="modal" data-target="#switchGroupModal">(wechseln)</a></div>
                <div>{{ Auth::user()->currentGroup->name }}</div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <div class="myAlert-bottom" id="alerts"></div>
                <h1 class="mt-4">@yield('title', 'Seitentitel')</h1>
                <ol class="breadcrumb mb-4">
                    @yield('breadcump')
                </ol>
                <x-layout.flash-message />
                @yield('content')
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; pascalschreiber.de 2021</div>
                    <div>
                        <!--<a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>-->
                        Version: 0.0.5
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
@stack('modal')
<x-layout.switch-group-modal />
<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
@stack('script')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css"/>
</body>
</html>
