@extends('layout.master')
@section('dashboard_page_title', 'ایمپورت اکسل آدرس ها')
@push('dashboard_extra_css')
    <link rel="stylesheet" href="{{ asset('/assets/css/dropzone.min.css') }}">
@endpush

@section('dashboard_content')
    <div class="container-fluid">
        <div class="card card-custom">
            <div class="card-body">
                <!--begin::Nav Content-->
                <div class="tab-content m-0 mt-4 p-0">
                    <div class="tab-pane active" id="tab_forms_widget_1" role="tabpanel">
                        <form action="{{ route('import.addresses') }}" class="dropzone text-center" id="my-great-dropzone">
                            @csrf
                            <img src="{{ asset('/assets/img/svg/excel.svg') }}" alt="" class="dz-image mt-8 mx-auto" data-dz-imgage width="48">
                            <div class="dz-message mb-0" data-dz-message><span>فایل اکسل <u><strong>آدرس ها</strong></u> را اینجا بکشید و رها کنید</span></div>
                        </form>
                    </div>
                </div>
                <!--end::Nav Content-->
            </div>
            <div class="card-footer text-right">
                <a id="duplicatedPlans" href="{{ route('export.address.notFounded') }}" class="btn btn-primary d-none" target="_blank">دانلود اکسل کاربران تکراری</a>
                <a id="errorsPlans" href="{{ route('export.address.emptyNationalityCode') }}" class="btn btn-primary d-none" target="_blank">دانلود اکسل کاربران ثبت نشده</a>
            </div>
        </div>
    </div>
@endsection

@push('dashboard_extra_js')
    <script src="{{ asset('/assets/js/dropzone.min.js') }}"></script>
    <script>
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
            init: function (){
                this.on('success', (file, response) => {
                    Swal.fire({
                        title: 'انجام شد',
                        text: 'ایمپورت اکسل با موفقیت انجام شد',
                        icon: 'success',
                    });

                    document.querySelector('#duplicatedPlans').classList.remove('d-none');
                    document.querySelector('#errorsPlans').classList.remove('d-none');
                });
                this.on('error', file => {
                    console.log('error')
                });
            }
        }
    </script>
@endpush
