<?php

namespace App\View\Components\Role\Util;

use Illuminate\View\Component;

class create extends Component
{
    public $role;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($role)
    {
        $this->role=$role;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.role.util.create');
    }
}
