<div class="toolbar d-flex align-items-center pl-3 border-bottom" >
    <div class="d-flex">
        {{ $slot }}
        <button class="btn btn-sm btn-primary d-flex align-items-center  mr-3" >
            <i class="material-icons-outlined " style="font-size:16px;">add</i>
            <span class="ml-1"> Nouveau</span>       
        </button>
        
    </div>
    <div class="d-flex ">
        <button class="btn btn-sm  d-flex align-items-center  mr-3" disabled id="update_id_btn">
            <i class="material-icons-outlined " style="font-size:16px;">edit</i>
            <span class="ml-1"> Modifier</span>       
        </button>
        <button class="btn btn-sm d-flex align-items-center  mr-3" disabled id="remove_action_bar" >
            <i class="material-icons-outlined " style="font-size:16px;">delete</i>
            <span class="ml-1"> Supprimer</span>       
        </button>
        
    </div>

    <div class=" mx-3 bg-secondary" style="height:18px;width: 1px;"></div>

    <div class="d-flex ">
        <button class="btn btn-sm d-flex align-items-center  mr-3"  >
            <i class="material-icons-outlined " style="font-size:16px;">print</i>
            <span class="ml-1"> Imprimer</span>       
        </button>
        <button class="btn btn-sm d-flex align-items-center mr-3" id="achive_btn_id" >
            <i class="material-icons-outlined " style="font-size:16px;">archive</i>
            <span class="ml-1"> Archiver</span>       
        </button>
        <button class="btn btn-sm d-flex align-items-center mr-3" disabled >
            <i class="material-icons-outlined " style="font-size:16px;">grade</i>
            <span class="ml-1">Favoris</span>       
        </button>
        
    </div>

    <div class=" mx-3 bg-secondary" style="height:18px;width: 1px;"></div>

    <div class="d-flex" style="z-index: 99999;">
        @if($filter)
            <x-npl::filters.filter :filter="$filter"/>
        @endif
        
        
        

    </div>
</div>