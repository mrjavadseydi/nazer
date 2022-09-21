@extends('layout.master')
@section('dashboard_page_title', 'لیست طرح ها')
@push('dashboard_extra_css')
    <style>
        #kt_body .table .table-row > div:nth-child(14){
            padding: 0!important;
        }
    </style>
@endpush

@section('dashboard_content')
    <div class="container-fluid p-0">
        @if( isset($data['supervisorID']) )
            <livewire:plans :supervisorid="$data['supervisorID']"/>
        @else
            <livewire:plans/>
        @endif
    </div>
@endsection

@push('dashboard_extra_js')
    @if( has_message() )
        @php $message = get_message(); @endphp
        <x-alert title="{{ $message['title'] }}" status="{{ $message['status'] }}" message="{{ $message['message'] }}" position="top-right"/>
    @endif
@endpush
