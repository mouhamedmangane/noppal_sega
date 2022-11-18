<?php

namespace App\Http\Controllers\Api\Reglement;

use App\Http\Controllers\Controller;
use App\Service\ReglementService;
use Illuminate\Http\Request;

class ReglementController extends Controller
{
    public function initReglement(){
       return  ReglementService::generateReglement();

    }
}
