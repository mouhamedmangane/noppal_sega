<?php


namespace App\View\Components\User\Util;


use Illuminate\View\Component;
use App\Models\Role;
use App\Models\Boutique;


class BoutiqueAccess extends Component
{

    public $user,$roles,$boutiques;

    private $boutiqueAccess=[]
            ,$editable;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user=null,$editable=false)
    {
        $this->user=$user;
        $this->editable=$editable;
        //
        $this->roles=Role::all()->pluck('nom','id');
        $this->boutiques=Boutique::all();
        
        if($user && isset($user->id)){
            $this->boutiqueAccess= $user->boutique_users;
            
        }
    }

    public function isCanWorkInBoutique($boutique){

    }

    public function getAccessBoutique($boutique){
        return collect($this->boutiqueAccess)->first(function($value,$key)use($boutique){
            return $value->boutique_id == $boutique->id;
        });
    }

    



    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if(!$this->editable)
            return view('components.user.util.boutique-access');
        else
            return view('components.user.util.boutique-access-editable');

    }
}
