@props([
    'id' => Npl\Brique\ViewModel\GenId::newId(),
    'idElement' => Npl\Brique\ViewModel\GenId::newId(),
    'filterSelect' => "filter-select-select",
])


<div id="{{ $id }}">

    @foreach ($ligne->data as $valeur => $label)

        @props([ 'idd' => Npl\Brique\ViewModel\GenId::newId(),])

        <a class="{{ $attributes['class'] }} dropdown-item text-sm ligne-filter-select p-0 " 
            style="font-size: 14px;">
            <span class="form-check form-check-inline w-100 d-inline-block " style="padding: 4px 10px">
                <input class="form-check-input ligne-filter-select-input {{ $filterSelect }}" type="checkbox" id="{{ $idd }}__{{ $loop->index }}" value="{{ $valeur }}">
                <label class="form-check-label w-100" for="{{ $idd }}__{{ $loop->index }}">{{ $label }}</label>
            </span>
        </a>  
        
    @endforeach

</div>


@if($ligne->idSearch)
@once
@push('script')
<script>
$(function(){
    $.addFilterSelect = (id,label,name,idSearch,idElement)=>{
        let op_name="select_egal";

        function run(){
            let value={
                    'op_name':op_name,
            };
            let text='';
            value['op']=[];
            $(id).find('.{{ $filterSelect }}').each(function(index){
                if($(this).prop('checked')){
                    if(index!=0)
                        text+=" ou "
                    text+=$(this).val();
                    value['op'].push($(this).val());
                }
            })
            if(text.length){
                                
                $.pushFilterToSearch(idSearch,idElement,id,name,value,label,text,".{{ $filterSelect }}");
            }
            else{
                
                if($("#"+idElement)){
                    $.removeFilterToSearch("#"+idElement,idSearch);
                }
            }
        }
        
        $(id).find('.{{ $filterSelect }}').on('change',function(){
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
                      "#{{ $id }}",
                      "{{ $ligne->label }}",
                      "{{ $ligne->name }}",
                      "#{{ $ligne->idSearch}}",
                      "{{ $idElement}}");
    });
     
</script>
   
@endpush
@endif
    

