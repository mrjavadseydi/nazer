<div>
    <a href="{{ route('branches.index', ['bank'=>$id]) }}" class="btn btn-sm btn-primary font-size-h5">
        شعب
    </a>
    <a href="{{ route('bank.edit', $id) }}" class="btn btn-sm btn-success font-size-h5">
        ویرایش
    </a>

    <a href="javascript:;" class="btn btn-sm btn-danger font-size-h5" data-remove>
        حذف
    </a>
    <form action="{{ route('bank.destroy', $id) }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
</div>
