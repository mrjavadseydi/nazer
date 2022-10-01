<?php

namespace App\Http\Livewire;

use App\Models\Observe;
use Livewire\Component;

class UpdateBpmsStatus extends Component
{
    public $observer_id, $bpms;
    public function mount($observer_id)
    {
        $this->bpms = Observe::find($observer_id);
    }
    public function updateStatus(){
        $this->bpms->update([
            'bpms_update_user' => auth()->user()->id,
            'on_bpms' => $this->bpms->on_bpms == 1 ? 0 : 1
        ]);
    }
    public function render()
    {
        return view('livewire.update-bpms-status');
    }

}
