<?php

namespace Npl\Brique\Util\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

Trait ArchiverTrait{


    abstract public  function getInfos();

    public function getTable(){
        if(isset($this->getInfos()['tableName'])){
            return $this->getInfos()['tableName'];
        }
        else{
            return strtolower($this->getInfos()['model']).'s';
        }
    }

    // Attribut for Request
    public function getAttribute(){
        return (isset($this->getInfos()['archived_attribute']))?$this->getInfos()['archived_attribute']:'archiver';
    }

    // Property for Database
    public function getIdTable(){
        return (isset($this->getInfos()['idTable']))?$this->getInfos()['idTable']:'id';
    }

    public function getSelectName(){
        if(isset($this->getInfos()['selectName'])){
            return $this->getInfos()['selectName'];
        }
        else{
            return strtolower($this->getInfos()['model']).'_select';
        }
    }



    public function archiver($id){
        return response()->json($this->abstractArchiver($id,1));
    }

    public function desarchiver($id){

        return response()->json($this->abstractArchiver($id,0));
    }

    public function archiverMany(Request $request){
        return response()->json($this->abstractArchiverMany($request,1));
    }

    public function desarchiverMany(Request $request){
        return response()->json($this->abstractArchiverMany($request,0));
    }

    private function abstractArchiver($id,$isAchived)
    {


        $validator=Validator::make(['id',$id],
        [
            'id'=>['numeric','exists:'.$this->getTable().','.$this->getIdTable()]
        ]);

        if($validator->fails()){
            return \Npl\Brique\Http\ResponseAjax\Validation::validate($validator);
        }
        else{
            return \Npl\Brique\Http\ResponseAjax\UpdateRow::manyForOnAttr($this->getTable(),[$id],
            [$this->getAttribute() =>$isAchived],
            ($isAchived)?'messages.nbr_archiver':'messages.nbr_desarchiver');
        }
    }

    private function abstractArchiverMany(Request $request,$isAchived){
        $selectName=$this->getSelectName();
        $validator=Validator::make($request->all(),
        [
            $selectName=>'array|required',
            $selectName.'.*'=>['numeric','exists:'.$this->getTable().','.$this->getIdTable()]
        ]);
        if($validator->fails()){
            return \Npl\Brique\Http\ResponseAjax\Validation::validate($validator);
        }
        else{
            return \Npl\Brique\Http\ResponseAjax\UpdateRow::manyForOnAttr($this->getTable(),$request->$selectName,
                                                                   [$this->getAttribute()=>$isAchived],
                                                                   ($isAchived)?'messages.nbr_archiver':'messages.nbr_desarchiver');
        }
    }
}
