<?php

namespace App\View\Components\Util;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Detail extends Component
{

    public $model;

    public $created_at_f="non defini",
           $update_at_f='non denfini',
           $user;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model=$model;
        if($model){
            $this->created_at_f= $model->created_at->format('d-m-Y H:i');
            $this->update_at_f= $model->updated_at->format('d-m-Y H:i');
            if(isset($model->done_by_user) && !empty($model->done_by_user))
            $this->user= User::where('id',$model->done_by_user)->first();
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.util.detail');
    }
}
