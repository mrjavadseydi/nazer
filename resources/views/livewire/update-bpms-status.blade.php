<div>
@if($bpms->on_bpms)
        <p @if(auth()->user()->isAdmin) wire:click="updateStatus" @endif  >
            @if($user= \App\Models\User::where('id',$bpms->bpms_update_user)->first())
                {{$user->firstName . " " . $user->lastName}}
            @else
                نا مشخص
            @endif
        </p>
    @else
        <a wire:click="updateStatus" style="color: #0e6662">
            ثبت نشده
        </a>
    @endif
</div>
