<?php

namespace App\Http\Controllers;

use App\ModelHaut\GenIdTronc;
use Illuminate\Http\Request;
use DB;
class GenIdTronController extends Controller
{
    public function coherence(Request $request){
        DB::beginTransaction();
        try {
        GenIdTronc::coherence();
        return response()->json([
            'status'=>true
        ]);
        DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status'=>false
            ]);
        }

    }
}
