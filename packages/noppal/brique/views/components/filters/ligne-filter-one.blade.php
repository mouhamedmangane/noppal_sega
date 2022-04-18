@props([
    'idCheck' => Npl\Brique\ViewModel\GenId::newId(),
    'idElement' => Npl\Brique\ViewModel\GenId::newId(),
    'idInput' => Npl\Brique\ViewModel\GenId::newId(),
    'idBtnOperation'=> Npl\Brique\ViewModel\GenId::newId(),
])
<a class="{{ $attributes['class'] }} dropdown-item text-sm ligne-filter-select p-0 " 
    style="font-size: 14px;">
    <span class="form-check form-check-inline w-100 d-inline-block" style="padding: 4px 10px">
        <input class="form-check-input ligne-filter-select-input" type="checkbox" id="{{ $idCheck }}" >
        <label class="form-check-label w-100" for="{{ $idCheck }}">{{ $ligne->label }}</label>
    </span>
    <div class="d-flex border " style="max-width:100%;margin: 1px 10px;">
        <button class="btn btn-sm btn-success px-0" style="width: 22px;text-align:center;" id="{{ $idBtnOperation }}"> </button>
        <input type="text" name="{{ $ligne->name }}[]" id="{{ $idInput }}" value="{{ $ligne->value }}" 
                class="form-control form-control-sm border-0"
                style="min-width:10px;" >
        
    </div>
</a>  
@if($ligne->idSearch)
@once
@push('script')
<script>
$(function(){
    $.addFilterSelect = (idInput,idCheck,label,name,idSearch,idElement,idBtnOperation,op_name)=>{
        let ops ={
            'egal':'=',
            'like':'lk',
            'superieur':'>',
            'inferieur':'<',
            'different':'\2260'
        };
        for (const cle in ops) {
           if(cle  == op_name){
                $(idBtnOperation).html(ops[cle]);
                $(idBtnOperation).data('it',cle);
                break;
           } 
        }
        function run(){
            if($(idCheck).prop('checked')){
                let value={
                    'op_name':op_name,
                    'valeur':$(idInput).val(),
                };
                let text=$(idInput).val();
                $.pushFilterToSearch(idSearch,idElement,idCheck,name,value,label,text);
                            
           }
            else{
                
                if($("#"+idElement)){
                    $.removeFilterToSearch("#"+idElement,idSearch);
                }
            }
        }
        
        $(idInput+' , '+idCheck).on('change',function(){
            run();
        });

    };

});
</script>    
@endpush
@endonce

@push('script')
<script>
    $(function(){
        $.addFilterSelect(
                      "#{{ $idInput }}",
                      "#{{ $idCheck }}",
                      "{{ $ligne->label }}",
                      "{{ $ligne->name }}",
                      "#{{ $ligne->idSearch}}",
                      "{{ $idElement}}",
                      "#{{ $idBtnOperation }}",
                      '{{ $ligne->op }}');
    });
     
</script>
   
@endpush
@endif