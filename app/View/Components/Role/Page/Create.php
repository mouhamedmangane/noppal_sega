<?php

namespace App\View\Components\Role\Page;
use App\Models\BoutiqueUser;
use App\Models\User;
use Illuminate\View\Component;

class Create extends Component
{
    public $role;

    public $statusRole,$couleurRole,$nbrUser;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($role)
    {
        $this->role=$role;
        $this->statusRole="Brouillon";
        $this->couleurRole="";
        $this->nbrUser=0;
        if($role->id && $role->id>0){
            if($role->archiver!=0){
                $this->statusRole="Archivé";
                $this->couleurRole="danger";
            }
            else{
                $this->statusRole="En Marche";
                $this->couleurRole="success";
            }
            $this->nbrUser=User::where('role_id',$role->id)->distinct()->count();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.role.page.create');
    }
}
