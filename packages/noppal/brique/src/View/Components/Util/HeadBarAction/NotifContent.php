<?php

namespace Npl\Brique\View\Components\Util\HeadBarAction;

use Illuminate\View\Component;

class NotifContent extends Component
{
    public $notifications;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->notifications =$this->initNotifications();
    }

    public function initNotifications(){
        return [
            (object)["type"=>"important","titre"=>"Epuissement Stock","link"=>"Voir Plus;/dashbord#test",
            "message"=>"le produit chololat est au niveau seuil veiller lancer reappro"],
            (object)["type"=>"info","titre"=>"Epuissement Stock","link"=>"Voir plus;/dashbord#test",
            "message"=>"le produit chololat est au niveau seuil veiller lancer reappro"],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.util.head-bar-action.notif-content');
    }
}
