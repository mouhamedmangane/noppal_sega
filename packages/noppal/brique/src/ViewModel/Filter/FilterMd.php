<?php
namespace Npl\Brique\ViewModel\Filter;

class FilterMd{
    private $ligneFilters,$idSearch;

    public function __construct($idSearch="",$ligneFilters=[]){
        $this->idSearch = $idSearch;
        $this->ligneFilters = $ligneFilters;
    }

    public function add(LigneFilterMd $ligne){
        foreach($this->ligneFilters as $ligne1){
            if($ligne->name==$ligne1->name )
                throw new \Exception("le nom $ligne->name exite plus d'1 fois dans le filter", 1);
            if($ligne->label==$ligne1->label )
                throw new \Exception("le label $ligne->label exite plus d'1 fois dans le filter", 1);
                
        }
        if(!empty($this->idSearch))
            $ligne->setIdSearch($this->idSearch);
        $this->ligneFilters[]=$ligne;
        return $this;
    }

    public function rows(){
        return $this->ligneFilters;
    }
}