<?php

namespace App\View\Components\User\Util;

use App\Models\Role;
use Illuminate\View\Component;

class Create extends Component
{
    public $user;

    public $roles;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user=$user;
        $this->roles=array_merge([0=>'Aucun Role'],Role::where('archiver',0)->get()->pluck('nom','id')->toArray());


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.user.util.create');
    }
}
