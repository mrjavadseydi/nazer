<div>
    <a href="javascript:;" class="btn btn-sm btn-success data-approve font-size-h5">
        تایید
    </a>
    <form action="{{ route('suggests.approve', $id) }}" id="approve" method="POST" class="d-none">
        @csrf
    </form>

    <a href="javascript:;" class="btn btn-sm btn-danger data-remove font-size-h5">
        حذف
    </a>
    <form action="{{ route('suggests.destroy', $id) }}" id="remove" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
</div>
