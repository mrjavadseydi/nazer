<div>
    @php
    if( isset($planID) )
        $id = $planID;
    @endphp
    <a href="{{ route('observes.create', $id) }}" class="btn btn-sm btn-primary font-size-h5">
        @isset($buttonName)
            {{ $buttonName }}
        @else
            ثبت نظارت
        @endisset
    </a>

    @isset($observeID)
        <a href="javascript:;" class="btn btn-sm btn-danger font-size-h5" data-remove>
            حذف
        </a>
        <form action="{{ route('observes.remove', $observeID) }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @endisset
</div>
