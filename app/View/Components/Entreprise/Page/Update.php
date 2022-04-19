<?php

namespace App\View\Components\Entreprise\Page;

use App\Models\Entreprise as Entreprise;
use Illuminate\View\Component;

class Update extends Component
{
    public $entreprise;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->entreprise= Entreprise::where('id',1)->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.entreprise.page.update');
    }
}
