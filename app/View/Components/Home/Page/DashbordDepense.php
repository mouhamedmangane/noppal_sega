<?php

namespace App\View\Components\Home\Page;

use Illuminate\View\Component;

class DashbordDepense extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.home.page.dashbord-depense');
    }
}
