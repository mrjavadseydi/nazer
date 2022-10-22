<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\BankBranch;
use App\Models\Plan;
use Livewire\Component;

class BankBrancheSelect extends Component
{
    public $plan_id,$banks,$bank_id,$branches=[],$last_bank_id=null,$last_branch_id=null;

    public function mount($plan_id=null)
    {
        $this->plan_id = $plan_id;
        $this->banks = Bank::all();
        $plan = Plan::find($plan_id);
        if ($plan->branch_id){
            $this->last_branch_id = $plan->branch_id;
            $this->last_bank_id = BankBranch::find($plan->branch_id)->bank_id;
            $this->bank_id =     $this->last_bank_id;
            $this->branches = BankBranch::where('bank_id',$this->last_bank_id )->get();
        }
    }
    public function updateBranches(){

        $this->branches = BankBranch::where('bank_id',$this->bank_id )->get();
    }
    public function render()
    {
        return view('livewire.bank-branche-select');
    }
}
