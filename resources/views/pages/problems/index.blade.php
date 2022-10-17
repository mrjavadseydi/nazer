@extends('layout.master')
@section('dashboard_page_title', 'لیست مشکلات')

@section('dashboard_content')
    <div class="container-fluid text-right p-0">
        <a href="{{ route('problem.create') }}" class="btn btn-primary btn-lg mr-6">افزودن مشکل</a>
        <livewire:problems/>
    </div>
@endsection

@push('dashboard_extra_js')
    <script>
        document.querySelectorAll('[data-remove]').forEach( item => {
            item.addEventListener('click', e => {
                e.preventDefault();

                Swal.fire({
                    title: 'حذف',
                    text: 'آیا از حذف کردن این مشکل اطمینان دارید؟',
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
