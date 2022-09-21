@extends('layout.master')
@section('dashboard_page_title', 'لیست ادارات')

@section('dashboard_content')
    <div class="container-fluid text-right p-0">
        <a href="{{ route('organizations.create') }}" class="btn btn-primary btn-lg mr-6">افزودن اداره جدید</a>
        <livewire:organizations/>
    </div>
@endsection

@push('dashboard_extra_js')
    <script>
        document.querySelectorAll('.data-remove').forEach( item => {
            item.addEventListener('click', e => {
                e.preventDefault();

                Swal.fire({
                    title: 'حذف',
                    text: 'آیا از حذف کردن این اداره اطمینان دارید؟',
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
