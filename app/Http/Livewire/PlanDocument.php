<?php

namespace App\Http\Livewire;

use App\Models\Document;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class PlanDocument extends Component
{
    public $item;
    protected $listeners = ['remove'];

    public function render()
    {
        $image = $this->item;
        return view('livewire.plan-document', compact('image'));
    }

    public function alertConfirm($id)
    {
        $this->dispatchBrowserEvent('swal', [
            'title' => 'حذف مدرک',
            'text' => 'از حذف کردن این مدرک اطمینان دارید؟',
            'icon' => 'question',
            'confirmButtonText' => 'بله',
            'showCancelButton' => true,
            'cancelButtonText' => 'خیر',
            'dangerMode' => true,
            'documentId' => $id
        ]);
    }

    public function remove(Document $document, Plan $plan)
    {
        dd('no');
        $fileURL = $document->image->url;
        $plan->documents()->detach($document->id);
        $document->image()->delete();
        File::delete(public_path() . '/uploads/' . $fileURL);

        $this->dispatchBrowserEvent('swal-result', [
            'title' => 'تایید',
            'text' => 'مدرک با موفقیت حذف شد',
            'icon' => 'success',
            'showConfirmButton' => false,
            'timer' => 2000
        ]);
    }
}
