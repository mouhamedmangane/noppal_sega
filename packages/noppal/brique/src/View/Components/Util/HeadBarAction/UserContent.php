<?php

namespace Npl\Brique\View\Components\Util\HeadBarAction;

use Illuminate\View\Component;
use App\Models\User;
use Auth;

class UserContent extends Component
{
    public $user,$photo_profil;
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct()
    {
        if(Auth::check()){
            $this->user = Auth::user();
        }else{
            $this->user = new User();
            $this->user->name =" Test Name User";
            $this->user->login ="Test Login user";

        }
        $this->photo_profil = $this->init_photo_profil();
    }

    public function init_photo_profil(){
        $path='images/users/'.$this->user->photo;
        if(file_exists(public_path($path)))
            return $path;
        return 'images/profig.jpg';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.util.head-bar-action.user-content');
    }
}
