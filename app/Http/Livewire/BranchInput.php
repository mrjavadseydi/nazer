<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BranchInput extends Component
{
    public $i=0,$form;

    public function mount($i=0,$form=null)
    {
        $this->i=$i;
        $this->form = $form;
    }

    public function add()
    {
        $this->i++;
    }
    public function render()
    {
        return view('livewire.branch-input');
    }
}
