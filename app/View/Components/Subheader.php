<?php

namespace App\View\Components;

use App\Classes\Parsers\PermissionUrlParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Subheader extends Component
{
    public $newButton;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->newButton = isset($request->newButton) ? $request->newButton : false;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.subheader');
    }
}
