<div>
    <a href="{{ route('organizations.edit', $id) }}" class="btn btn-sm btn-success font-size-h5">
        ویرایش
    </a>

    <a href="javascript:;" class="btn btn-sm btn-danger font-size-h5" data-remove>
        حذف
    </a>
    <form action="{{ route('organizations.destroy', $id) }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
</div>
