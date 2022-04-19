<?php

namespace App\Http\Middleware;

use App\Util\Access;
use Closure;
use Illuminate\Http\Request;

class Droit
{


    public function __construct(){

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$objet=null,$droits=null)
    {
        $droits=explode(";",$droits);
        if(Access::canAccess($objet,$droits)){
            return $next($request);
        }
        else{
            return abort('404');
        }

    }
}
