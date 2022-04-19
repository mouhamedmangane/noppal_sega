<?php

namespace App\View\Components\Contact\Util;

use App\Models\Telephone;
use Illuminate\View\Component;
use Npl\Brique\Util\NplStringFormat;
use DataTables;

class Voir extends Component
{

    public $contact;

    public $tels=['Aucun','Aucun'];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($contact)
    {
        $this->contact=$contact;
        $telephones= Telephone::where('contact_id',$contact->id)->get();
        if(count($telephones)){
            $i=0;
            foreach ($telephones as $key => $value) {
                if($value->numero)
                    $this->tels[$i]= NplStringFormat::telephone($value->numero.'',$value->indicatif.'');
                else
                    $this->tels[$i]='Aucun';
                $i++;
            }
        }
    }

    public function titre(){
        $data= [
            (object)  ['name'=>'Bois','propertyName'=>'bois'],
            (object)  ['name'=>'Prix Vente','propertyName'=>'prix_vente'],
            (object)  ['name'=>'Prix Achat ','propertyName'=>'prix_achat'],
            (object)  ['name'=>'Modifier le','propertyName'=>'created_at_f'],

        ];

    //    dd($data);


        return $data;
    }
    public function contact_prix(){
        $contact_prixs=$this->contact->contact_prix;
        $dataTable = DataTables::of($contact_prixs)
        ->addColumn('bois',function($contact_prix){
            return $contact_prix->bois->name;
        })
        ->addColumn('prix_vente',function($contact_prix){
            return number_format($contact_prix->prix_vente,0,',',' '). 
                view('npl::components.bagde.badge')
                ->with('text',"FCFA")
                ->with('class','badge-success');
        })
        ->addColumn('prix_achat',function($contact_achat){
            return  
                view('npl::components.bagde.badge')
                ->with('text','FCFA')
                ->with('class','badge-success');
        })
        ->addColumn("created_at_f",function($contact_prix){

            return ($contact_prix->created_at)?$contact_prix->created_at->format('d-m-Y H:i'):'non defini';
        })
         ->addColumn("updated_at_f",function($contact_prix){
            return ($contact_prix->updated_at)?$contact_prix->updated_at->format('d-m-Y H:i'):'non-defini';
        })
        ->rawColumns(['bois','prix_achat','prix_vente','created_at_f',"updated_at_f"])
        ->make(true);
     
        $response=$dataTable->getData(true);
        return $response['data'];
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.contact.util.voir');
    }
}
