<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
    <!--begin::Container-->
    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted font-weight-bold mr-2">2022©</span>
            <a href="https://daneshjooyar.info" target="_blank" class="text-dark-75 text-hover-primary">ساخته شده با ❤️ توسط شرکت دانشجویار</a>
        </div>
        <!--end::Copyright-->
        <!--begin::Nav-->
        <div class="nav nav-dark">
            @php
                $locale = \Illuminate\Support\Facades\Lang::getLocale();
            @endphp
            @foreach(\Illuminate\Support\Facades\Config::get('menu.footer') as $item)
                <a href="{{ $item['url'] }}" target="_blank" class="nav-link @if($locale == 'fa') pl-5 pr-0 @else pl-0 pr-5 @endif">{{$item['title']}}</a>
            @endforeach
        </div>
        <!--end::Nav-->
    </div>
    <!--end::Container-->
</div>
