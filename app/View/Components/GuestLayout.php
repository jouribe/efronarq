<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function render(): View|Factory|\Illuminate\View\View|Application
    {
        return view('layouts.guest');
    }
}
