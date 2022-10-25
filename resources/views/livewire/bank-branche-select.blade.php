<div class="col-12">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label for="" class="form-label">بانک</label>
                <select required class="form-control" name="bank_id" wire:change="updateBranches" wire:model="bank_id" wire:model="last_bank_id">
                    @if(!$last_bank_id)
                        <option value="" selected >انتخاب کنید</option>
                    @endif
                    @foreach($banks as $bank)
                        <option value="{{ $bank->id }}" {{$bank->id == $last_bank_id  ? "selected":""}}  >{{ $bank->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group px-3">
                <label for="" class="form-label">شعبه</label>

                <select class="form-control" name="branch_id">

                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}"  {{$last_branch_id == $branch->id ? "selected":""}} >{{ $branch->name ." - " . $branch->code }}@if( $branch->city->title){{" - ". $branch->city->title}}@endif</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
