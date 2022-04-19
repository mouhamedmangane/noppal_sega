<?php

namespace App\View\Components\Role\Util;

use Illuminate\View\Component;

class DroitObjet extends Component
{
    public $objet,$roleObjet;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($objet,$roleObjet=null)
    {
        $this->objet=$objet;

        if($roleObjet)
            $this->roleObjet=$roleObjet;
        else
            $this->roleObjet= $this->newRoleObjet();
    }


    private function newRoleObjet(){
        return (object) [
            'role_id'=> 0 ,'objet_id'=>0,
            'c'=>false,'r'=>false,'u'=>false,'d'=>false,
            'co'=>false,'ro'=>false,'uo'=>false,'do'=>false
        ];
    }

    public function isCheck($element){
        if(isset($element) && $element){
            return 'true';
        }
        else{
            return 'false';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.role.util.droit-objet');
    }
}
