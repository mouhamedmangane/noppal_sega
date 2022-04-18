<?php

namespace App\View\Components\User\Page;
use App\Models\Role;


use Illuminate\View\Component;

class Create extends Component
{
    public $user;
    public $roles;
    public $couleurUser,$statusUser;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user=$user;
        $this->statusUser="Brouillon";
        $this->couleurUser="";
        $this->roles=Role::where('archiver',0)->get()->pluck('nom','id');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.user.page.create');
    }
}
