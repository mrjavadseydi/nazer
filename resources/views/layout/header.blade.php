<!DOCTYPE html>
<html lang="en" dir="rtl">
<!--begin::Head-->
<head><base href="">
    <meta charset="utf-8" />
    <title>@yield('dashboard_page_title')</title>
    <meta name="description" content="Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!--begin::Fonts-->
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ url('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ url('assets/css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/themes/layout/brand/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/themes/layout/aside/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/rtl.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/css/font.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/plugins/global/sweetalert/sweetalert2.min.css') }}">
    <style>
        .loading{
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 999;
            transition: opacity 0.5s;
        }

        .loading.hide{
            opacity: 0;
        }

        .loading .loading-progress{
            width: 100px;
            height: 100px;
            border-bottom: 5px solid #2ea6e0;
            animation-name: rotate;
            animation-duration: 1s;
            animation-iteration-count: infinite;
            animation-direction: alternate-reverse;
            animation-timing-function: ease-in-out;
            border-radius: 100%;
        }

        @keyframes rotate {
            from{
                transform: rotate(0deg)
            }
            to{
                transform: rotate(360deg)
            }
        }

        @media screen and (min-width: 600px) {
            * {
                font-size: 18px !important;
            }

            .table .table-row:first-child > div button{
                padding: 1.5em !important;
                font-size: 16px;
            }

            .table .table-row:not(:nth-child(2)):not(:first-child) > div{
                padding: 1em !important;
            }

            .loading{
                width: calc(100vw - 265px); /* 265px width of aside */
            }
        }

        @media screen and (max-width: 600px) {
            .table .table-row:first-child > div button{
                padding: 0.5em!important;
                font-size: 13px;
            }

            .table .table-row:not(:nth-child(2)):not(:first-child) > div{
                padding: 0.5em !important;
            }

            .loading{
                width: 100vw;
            }
        }

        .swal2-popup.swal2-modal{
            place-items: center;
        }

        .table .table-row:first-child > div, .table .table-row:first-child, .table, .container-fluid .rounded-lg.rounded-b-none.shadow-lg{
            border: unset!important;
        }

        .table .table-row:first-child > div button{
             font-weight: bold;
             color: white;
             text-shadow: 0 0 1px;
             line-height: 1.3rem;
             background-color: #2ea6e0;
        }

        .table .table-row:not(:first-child) > div{
            font-size: 15px;
        }

        table .table-row.bg-blue-100{
            box-shadow: 0 -10px 100px;
        }

        .table .table-row:not(:nth-child(2)):not(:first-child) > div{
            border: 1px solid #e7e7e7;
        }

        .container-fluid .rounded-lg.rounded-b-none.shadow-lg{
            border-radius: 0!important;
        }

        .table .table-cell button{
            text-align: right!important;
        }
    </style>
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ url('favicon.ico') }}" />
    @livewireStyles
    <link rel="stylesheet" href="{{ url('assets/css/tailwind.min.css') }}" integrity="sha512-l7qZAq1JcXdHei6h2z8h8sMe3NbMrmowhOl+QkP3UhifPpCW2MC4M0i26Y8wYpbz1xD9t61MLT9L1N773dzlOA==" crossorigin="anonymous" />
    @stack('dashboard_extra_css')
</head>
