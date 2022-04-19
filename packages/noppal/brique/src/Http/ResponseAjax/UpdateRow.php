<?php

namespace Npl\Brique\Http\ResponseAjax;
use DB;

class UpdateRow{



    public static function  manyForOnAttr($table,$ids,Array $updateSets,$succesMessage,$attr='id'){
        DB::beginTransaction();
        try {
            foreach($ids as $id){
                $model=DB::table($table)->where($attr,$id)->update($updateSets);

            }

            DB::commit();
            return [
                'status'=>true,
                'message'=>__($succesMessage,['nombre'=>1])
            ];
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return [
                'status'=>false,
                'message'=>__('messages.erreur_inconnu').' '.__('messages.operation_encore')
            ];
        }
    }


}
