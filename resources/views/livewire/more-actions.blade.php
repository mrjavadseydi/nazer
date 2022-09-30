<div class="dropdown dropdown-inline">
    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" data-toggle="dropdown">
        <span class="svg-icon svg-icon-md">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32px" height="32px" viewBox="0 0 32 32" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <circle fill="#000000" cx="16" cy="12" r="2"/>
                    <circle fill="#000000" cx="16" cy="19" r="2"/>
                    <circle fill="#000000" cx="16" cy="26" r="2"/>
                </g>
            </svg>
        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
        <ul class="navi flex-column navi-hover py-2">
            <li class="navi-header font-weight-bolder text-uppercase font-size-xs text-primary pb-2">
                عملیات
            </li>
            <li class="navi-item">
                <a href="#" class="navi-link">
                    <button type="button" data-toggle="modal" data-target="#modal-{{ $id  }}">
                        <span class="navi-icon"><i class="la la-user"></i></span>
                        <span class="navi-text">ویرایش ناظر</span>
                    </button>

                </a>

                <a href="#" class="navi-link">
                    <button type="button" >
                        <span class="navi-icon"><i class="la la-pen"></i></span>
                        <span class="navi-text">اطلاعات پرونده</span>
                    </button>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="modal fade" id="modal-{{ $id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ویرایش ناظر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0 10px" class="text-right m-0">
                        <div class="form-group">
                            <label for="" class="form-label">ناظر فعلی</label>
                            <input type="text" class="form-control" value="{{ $supervisorFullName }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">ناظر جدید</label>
                            <select name="supervisor" id="" class="form-control" wire:change="saveSupervisor({{ $id }}, $event.target.value)">
                                <option value=""></option>
                                @foreach($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}">{{ $supervisor->fullName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>