<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">
            <!--begin::Page Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ app()->view->getSections()['dashboard_page_title'] }}</h5>
            <!--end::Page Title-->
        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
{{--            <!--begin::Actions-->--}}
{{--            <a href="#" class="btn btn-clean btn-sm font-weight-bold font-size-base mr-1">@lang('authentication::subheader.' . strtolower('Today'))</a>--}}
{{--            <a href="#" class="btn btn-clean btn-sm font-weight-bold font-size-base mr-1">@lang('authentication::subheader.' . strtolower('Month'))</a>--}}
{{--            <a href="#" class="btn btn-clean btn-sm font-weight-bold font-size-base mr-1">@lang('authentication::subheader.' . strtolower('Year'))</a>--}}
{{--            <!--end::Actions-->--}}
            <!--begin::Dropdowns-->
            <div class="dropdown dropdown-inline" data-toggle="tooltip" title="دسترسی سریع" data-placement="left">
                <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="svg-icon svg-icon-success svg-icon-lg">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Files/File-plus.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                </a>
                <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right py-3">
                    <!--begin::Navigation-->
                    <ul class="navi navi-hover py-5">
                        @foreach(\Illuminate\Support\Facades\Config::get('menu.quick') as $item)
                            <li class="navi-item">
                                <a href="{{ $item['url'] }}" class="navi-link text-right">
                                    <span class="navi-icon">
                                        <i class="{{ $item['icon'] }}"></i>
                                    </span>
                                    <span class="navi-text text-right">{{ strtolower($item['title']) }}</span>
                                </a>
                            </li>
                            @isset( $item['separator'] )
                                @if( $item['separator'] == true )
                                    <li class="navi-separator my-3"></li>
                                @endif
                            @endisset
                        @endforeach
                    </ul>
                    <!--end::Navigation-->
                </div>
            </div>
            <!--end::Dropdowns-->
        </div>
        <!--end::Toolbar-->
    </div>
</div>
