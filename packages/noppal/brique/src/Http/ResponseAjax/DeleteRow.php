<?php

namespace Npl\Brique\Http\ResponseAjax;
use DB;

class DeleteRow{
    // le parametre clause est un tableau qui attend 3 ou 4 parametre
    //le params sont respectivement l' attribut, la valeur, la clause et l'operation
    private static function delete($table,$clauses){

        $model= DB::table($table);
        foreach($clauses as $clause){
            $nameClause=$clause[2];
            if(count($clause)<4){
                $model->$nameClause($clause[0],$clause[1]);
            }
            else{
                $model->$nameClause($clause[0],$clause[3],$clause[1]);
            }

        }
        $model->delete();

    }


    public static function  one($table,$id,$attr='id',$callable=null){
        DB::beginTransaction();
        try {

            self::delete($table,[[$attr,$id,'where']]);
            if($callable){
                $callable($id);
            }

            DB::commit();
            return [
                'status'=>true,
                'message'=>__('messages.nbr_supprimer',['nombre'=>1])
            ];
        } catch (\Throwable $th) {
            DB::rollback();
            return [
                'status'=>false,
                'message'=>__('messages.erreur_inconnu').' '.__('messages.operation_encore')
            ];
        }
    }

    public static function  many($table,Array $ids,$attr='id',$callable=null,$callableBefore=null){
        DB::beginTransaction();
        try {
            if($callableBefore)
                $callableBefore($ids);
            foreach($ids as $id){
                self::delete($table,[[$attr,$id,'where']]);
            }
            if($callable){
                $callable($ids);
            }
            DB::commit();
            return [
                'status'=>true,
                'message'=>__('messages.nbr_supprimer',['nombre'=>count($ids)])
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
