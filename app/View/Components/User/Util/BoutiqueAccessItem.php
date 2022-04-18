<?php

namespace App\View\Components\User\Util;

use Illuminate\View\Component;

class BoutiqueAccessItem extends Component
{
    public $boutique,$boutiqueAccess,$roles;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($boutique,$boutiqueAccess,$roles)
    {
        $this->boutique=$boutique;
        $this->boutiqueAccess=$boutiqueAccess;
        $this->roles=$roles;
    }

    public function getIdRoleForSelect(){
        return (isset($this->boutiqueAccess)) ? $this->boutiqueAccess->role_id : -1;
    }


    public function isActive(){
        if(isset($this->boutiqueAccess) && $this->boutiqueAccess->activer>0)
            return true;
        else
            return false;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.user.util.boutique-access-item');
    }
}
