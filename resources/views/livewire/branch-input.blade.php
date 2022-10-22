<div>
    <span class="btn btn-primary" wire:click="add"><i class="flaticon-add"></i> </span>
    @for($j=$i;$j>0;$j--)

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group">
                    <label for="" class="form-label">نام شعبه</label>
                    <input required type="text" class="form-control" name="branchName[]"
                          @if($j==1) @isset($form) value="{{ $form->name }}" @endisset @endif>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group">
                    <label for="" class="form-label">کد شعبه</label>
                    <input required type="text" class="form-control" name="branchCode[]"
                           @if($j==1) @isset($form) value="{{ $form->code }}" @endisset  @endif>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="form-label">آدرس</label>
                    <input required type="text" class="form-control" name="branchAddress[]"
                           @if($j==1)  @isset($form) value="{{ $form->address }}" @endisset  @endif>
                </div>
            </div>

        </div>
        <hr>
    @endfor

</div>
