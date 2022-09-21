@extends('layout.master')
@section('dashboard_page_title', 'لیست دوره ها')

@section('dashboard_content')
    <div class="container-fluid text-right p-0">
        <a href="{{ route('courses.create') }}" class="btn btn-primary btn-lg mr-6">افزودن دوره جدید</a>
        <livewire:courses/>
    </div>
@endsection

@push('dashboard_extra_js')
    <script>
        document.querySelectorAll('[data-remove]').forEach( item => {
            item.addEventListener('click', e => {
                e.preventDefault();

                Swal.fire({
                    title: 'حذف',
                    text: 'آیا از حذف کردن این دوره اطمینان دارید؟',
                    icon: 'question',
                    confirmButtonText: 'بله',
                    showCancelButton: true,
                    cancelButtonText: 'خیر'
                }).then( result => {
                    if( result.isConfirmed ){
                        item.closest('div').querySelector('form').submit();
                    }
                } );
            });
        } )
    </script>
@endpush
