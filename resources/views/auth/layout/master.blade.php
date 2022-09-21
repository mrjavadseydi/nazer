@include('auth.layout.header')
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        @yield('auth_content')
        <!--end::Login-->
    </div>
    <!--end::Main-->
</body>
<!--end::Body-->
@include('auth.layout.footer')
