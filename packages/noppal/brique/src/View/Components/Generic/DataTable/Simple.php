<?php

namespace Npl\Brique\View\Components\DataTable;

use Illuminate\View\Component;

class Simple extends Component
{
    public $name,//nom de la variable datatable dans le js
           $columns,
           $url,
           $dataa,
           $searchId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$columns,$url=null,$data=null,$searchId="")
    {
        $this->name = $name;
        $this->columns = $columns;
        $this->url = $url;
        $this->dataa=$data;
        $this->searchId =$searchId;
    }

    public function nameColumns(){
        $names=[];
        foreach($this->columns as $col){
            $names[]=$col->propertyName;
        }
        return $names; 
    }
    

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render(){
        return view('npl::components.data-table.simple');
    }
}
