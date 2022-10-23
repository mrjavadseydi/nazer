<div>
    <a href="{{ route('report.13', ['supervisor'=>$id]) }}" class="btn btn-sm btn-primary font-size-h5">
        مشاهده فرم ۱۳
    </a>
    <a href="{{ route('supervisors.edit', $id) }}" class="btn btn-sm btn-success font-size-h5">
        ویرایش
    </a>

    <a href="javascript:;" class="btn btn-sm btn-danger font-size-h5" data-remove>
        حذف
    </a>
    <form action="{{ route('supervisors.destroy', $id) }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
</div>
