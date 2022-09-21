@extends('layout.master')
@section('dashboard_page_title', 'لیست دوره های پیشنهادی')

@section('dashboard_content')
    <div class="container-fluid text-right p-0">
        <livewire:suggests/>
    </div>
@endsection

@push('dashboard_extra_js')
    <script>
        document.querySelectorAll('.data-remove').forEach( item => {
            item.addEventListener('click', e => {
                e.preventDefault();

                Swal.fire({
                    title: 'حذف',
                    text: 'آیا از حذف این دوره پیشنهادی اطمینان دارید؟',
                    icon: 'question',
                    confirmButtonText: 'بله',
                    showCancelButton: true,
                    cancelButtonText: 'خیر'
                }).then( result => {
                    if( result.isConfirmed ){
                        item.closest('div').querySelector('form#remove').submit();
                    }
                } );
            });
        } )

        document.querySelectorAll('.data-approve').forEach( item => {
            item.addEventListener('click', e => {
                e.preventDefault();
                item.closest('div').querySelector('form#approve').submit();
            });
        } )
    </script>
@endpush
