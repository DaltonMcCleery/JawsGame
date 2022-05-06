<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Action extends Component
{
   public function __construct(
       public string $action,
       public string $currentAction,
   ) {
       //
   }

    public function render()
    {
        return view('components.action');
    }
}
