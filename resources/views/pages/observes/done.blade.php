@extends('layout.master')
@section('dashboard_page_title', 'بازدید های انجام شده')

@section('dashboard_content')
    <div class="container-fluid">
        @if( isset($data['planID']) )
            <livewire:observes :planid="$data['planID']"/>
        @elseif( isset($data['supervisorID']) and isset($data['persianFrom']) and isset($data['persianTo']) )
            <livewire:observes :supervisorid="$data['supervisorID']" :persianfrom="$data['persianFrom']" :persianto="$data['persianTo']"/>
        @elseif( isset($data['supervisorID']) )
            <livewire:observes :supervisorid="$data['supervisorID']"/>
        @else
            <livewire:observes/>
        @endif
    </div>
@endsection

@push('dashboard_extra_js')
    <script>
        document.querySelectorAll('[data-remove]').forEach( item => {
            item.addEventListener('click', e => {
                e.preventDefault();

                Swal.fire({
                    title: 'حذف',
                    text: 'آیا از حذف کردن این نظارت اطمینان دارید؟',
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
