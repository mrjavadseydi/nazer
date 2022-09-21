@extends('layout.master')
@section('dashboard_page_title', 'ثبت پرونده')
@push('dashboard_extra_css')
    <link rel="stylesheet" href="{{ asset('/assets/css/steps.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/persian-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/tagify.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('dashboard_content')
    <div class="container-fluid">
        <div class="card card-custom gutter-b">
            <!--begin::Body-->
            <div class="card-body">
                <!--begin::Nav Tabs-->
                <ul class="dashboard-tabs nav nav-pills nav-primary row row-paddingless m-0 p-0 flex-column flex-sm-row" role="tablist">
                    <!--begin::Item-->
                    <li class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                        <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center active" data-toggle="pill" href="#tab_forms_widget_1">
                    <span class="nav-icon py-2 w-auto">
                        <span class="svg-icon svg-icon-3x">
                            <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Home/Library.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000"></path>
                                    <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1"></rect>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </span>
                            <span class="nav-text font-size-lg py-2 font-weight-bold text-center">ثبت فایل اکسل</span>
                        </a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                        <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center" data-toggle="pill" href="#tab_forms_widget_2">
                        <span class="nav-icon py-2 w-auto">
                            <span class="svg-icon svg-icon-3x">
                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                        <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </span>
                            <span class="nav-text font-size-lg py-2 font-weight-bolder text-center">ثبت دستی</span>
                        </a>
                    </li>
                    <!--end::Item-->
                </ul>
                <!--end::Nav Tabs-->
            </div>
            <!--end::Body-->
        </div>

        <div class="card card-custom">
            <div class="card-body">
                <!--begin::Nav Content-->
                <div class="tab-content m-0 mt-4 p-0">
                    <div class="tab-pane active" id="tab_forms_widget_1" role="tabpanel">
                        <form action="{{ route('import') }}" class="dropzone text-center" id="my-great-dropzone">
                            @csrf
                            <img src="{{ asset('/assets/img/svg/excel.svg') }}" alt="" class="dz-image mt-8 mx-auto" data-dz-imgage width="48">
                            <div class="dz-message mb-0" data-dz-message><span>فایل اکسل را اینجا بکشید و رها کنید</span></div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab_forms_widget_2" role="tabpanel">
                        <form id="accept_plan" action="{{ route('plans.store') }}" method="POST">
                            @csrf
                            <h3>اطلاعات فردی</h3>
                            <section>
                                <div class="row text-right">
                                    <div class="col-4">
                                        <div class="form-group pl-3">
                                            <label for="" class="form-label">نام</label>
                                            <input type="text" class="form-control" name="performer[firstName]">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group px-3">
                                            <label for="" class="form-label">نام خانوادگی</label>
                                            <input type="text" class="form-control" name="performer[lastName]">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group pr-3">
                                            <label for="" class="form-label">کد ملی</label>
                                            <input type="text" class="form-control" name="performer[nationalityCode]">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group pl-3">
                                            <label for="" class="form-label">تاریخ تولد</label>
                                            <input type="text" class="form-control persianDate" name="performer[birthday]">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group px-3">
                                            <label for="" class="form-label">شماره تلفن</label>
                                            <input type="text" class="form-control" name="performer[phone]">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group pr-3">
                                            <label for="" class="form-label">جنسیت</label>
                                            <div class="radio-inline">
                                                <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                    <input type="radio" name="performer[gender]" checked="checked" value="male"/>
                                                    <span class="mr-0 ml-2"></span>
                                                    مرد
                                                </label>
                                                <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                    <input type="radio" name="performer[gender]" value="female"/>
                                                    <span class="mr-0 ml-2"></span>
                                                    زن
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group pl-3">
                                            <label for="" class="form-label">تحت پوشش کمیته امداد</label>
                                            <div class="radio-inline">
                                                <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                    <input type="radio" name="performer[support]" checked="checked"/>
                                                    <span class="mr-0 ml-2"></span>
                                                    بله
                                                </label>
                                                <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                    <input type="radio" name="performer[support]" />
                                                    <span class="mr-0 ml-2"></span>
                                                    خیر
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <h3>اطلاعات طرح</h3>
                            <section>
                                <div class="row text-right">
                                    <div class="col-4">
                                        <div class="form-group pl-3">
                                            <label for="" class="form-label">عنوان</label>
                                            <input type="text" class="form-control" name="plan[title]">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group px-3">
                                            <label for="" class="form-label">دسته</label>
                                            <input type="text" class="form-control" name="plan[category]">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group pr-3">
                                            <label for="" class="form-label">برچسب ها</label>
                                            <input type="text" class="form-control" name="plan[tags]" id="tagify">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group pl-3">
                                            <label for="" class="form-label">اداره</label>
                                            <select class="form-control" name="plan[organization]">
                                                @foreach($organizations as $organization)
                                                    <option value="{{ $organization->id }}">{{ $organization->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group pl-3">
                                            <label for="" class="form-label">مسافت</label>
                                            <input type="number" class="form-control" name="plan[distance]">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group px-3">
                                            <label for="" class="form-label">نوع طرح</label>
                                            <div class="radio-inline">
                                                <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                    <input type="radio" name="plan[implement_method]" value="هدایت شغلی" checked="checked"/>
                                                    <span class="mr-0 ml-2"></span>
                                                    هدایت شغلی
                                                </label>
                                                <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                    <input type="radio" name="plan[implement_method]" value="راهبری شغلی" />
                                                    <span class="mr-0 ml-2"></span>
                                                    راهبری شغلی
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group pl-3">
                                            <label for="" class="form-label">آدرس</label>
                                            <input type="text" class="form-control" name="plan[address]">
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <h3>ارجاع به کارشناس فنی</h3>
                            <section>
                                <div class="row text-right">
                                    <div class="col-4">
                                        <div class="form-group pl-3">
                                            <label for="" class="form-label">کارشناس فنی (ناظر)</label>
                                            <select class="form-control select2-generate" name="supervisor">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
                <!--end::Nav Content-->
            </div>
        </div>
    </div>
@endsection

@push('dashboard_extra_js')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="{{ asset('/assets/js/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('/assets/js/persian-date.min.js') }}"></script>
    <script src="{{ asset('/assets/js/persian-datepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/js/dropzone.min.js') }}"></script>
    <script src="{{ asset('/assets/js/tagify.js') }}"></script>
    <script src="{{ asset('/assets/js/tagify.polyfills.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $("#accept_plan").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: $.fn.steps.transitionEffect.none,
            transitionEffectSpeed: 200,
            autoFocus: true,
            titleTemplate: '<p class="number">#index#</p><p>#title#</p>',
            labels: {
                current: "",
                finish: "ثبت پرونده",
                next: "بعدی",
                previous: "قبلی",
            },
            onFinished: function (event, currentIndex) {
                const Toast = Swal.mixin({
                    position: 'center',
                    showConfirmButton: true,
                    showCancelButton: true,
                    cancelButtonText: "خیر",
                    confirmButtonText: "بله",
                });

                Toast.fire({
                    icon: 'question',
                    title: 'ثبت درخواست',
                    text: 'آیا از صحت اطلاعات وارد شده مطمئن هستید؟ اگر مطمئن هستید، روی دکمه «بله» کلیک کنید تا درخواست شما ثبت شود. برای بازبینی یا بازگشت، دکمه «خیر» را کلیک کنید'
                }).then(result => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'info',
                            title: 'لطفا منتظر بمانید ...',
                            showCancelButton: false,
                            showCloseButton: false,
                            showConfirmButton: false,
                            showDenyButton: false,
                        })
                        document.querySelector('#accept_plan').submit();
                    }
                })
            }
        });

        $(document).ready(function() {
            $(".persianDate").pDatepicker({
                format: 'YYYY/MM/DD'
            });
        });


        Dropzone.options.myGreatDropzone = {
            paramName: "file",
            maxFilesize: 20,
            dictFileTooBig: "اندازه فایل آپلود شده، بیش از حداکثر حجم قابل آپلود است" + "\n" + "حداکثر حجم آپلود: {{ "\{\{maxFilesize\}\}" }}MB",
            dictInvalidFileType: "فایل آپلود شده غیرمجاز است",
            dictCancelUpload: "لغو آپلود",
            dictUploadCanceled: "آپلود فایل لغپ شد",
            dictCancelUploadConfirmation: "آیا از لغو فرآیند آپلود اطمینان دارید؟",
            dictRemoveFile: "حذف فایل",
            dictMaxFilesExceeded: "نمی توانید بیش از این فایل دیگری آپلود کنید",
            dictFileSizeUnits: { tb: "ترابایت", gb: "گیگابایت", mb: "مگابایت", kb: "کیلوبایت", b: "بایت" },
        }

        var input = document.querySelector('#tagify'),
        tagify = new Tagify(input);

        $(document).ready(function() {
            $('.select2-generate').select2({
                ajax: {
                    url: '{{ route('supervisors.index') }}',
                    dataType: 'json'
                }
            });
        });
    </script>
@endpush
