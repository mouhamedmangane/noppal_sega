@props([
    'id' => Npl\Brique\ViewModel\GenId::newId(),
    'idCkeck' => Npl\Brique\ViewModel\GenId::newId(),
    'idInputMin' => Npl\Brique\ViewModel\GenId::newId(),
    'idInputMax' => Npl\Brique\ViewModel\GenId::newId(),
    'idBtnOperation'=> Npl\Brique\ViewModel\GenId::newId(),
    'idElement' => Npl\Brique\ViewModel\GenId::newId(),
])
<a class="{{ $attributes['class'] }} dropdown-item text-sm ligne-filter-select p-0  " id="{{ $id }}"
    style="font-size: 14px;">

    <span class="form-check form-check-inline w-100 d-inline-block" style="padding: 4px 10px;">
        <input class="form-check-input ligne-filter-select-input" id="{{ $idCkeck }}" type="checkbox"  value="option1">
        <label class="form-check-label" for="{{ $idCkeck }}" >{{ $ligne->label }}</label>
    </span>


    <div class="d-flex border" style="max-width:100%;margin: 1px 10px;">

        <input type="{{ $ligne->type }}" id="{{ $idInputMin }}" style="min-width:10px;" class="form-control form-control-sm no-spinner no-date-spinner">
        <button class="btn btn-sm btn-success px-0"  data-id-element="{{ $idElement }}"
                style="width: 22px;text-align:center;" id="{{ $idBtnOperation }}"></button>
        <input type="{{ $ligne->type }}" id={{ $idInputMax }} style="min-width:10px;" class="form-control form-control-sm border-0 no-spinner no-date-spinner">

    </div>

</a>

@if($ligne->idSearch)
@once
@push('script')
<script>
$(function(){
    $.addFilterNumber = (id,label,name,idSearch,idCkeck,idInputMin,idInputMax,idBtnOperation,op_name)=>{
        let ops=[
            {text:"=",op_name:"egal"},
            {text:'<>',op_name:'interval'},
            {text:'\u2264\u2265',op_name:"interval_egal"}
        ];

        // Initialisation du button
        for (const [i,op] of ops.entries()) {
           if(op.op_name == op_name){
                $(idBtnOperation).html(ops[i].text);
                $(idBtnOperation).data('it',i);
                break;
           }
        }
        // masquage de inputMIn  lorqu elle est egal a egal
        if(op_name == ops[0].op_name){

            $(idInputMin).hide();
        }



        function nextOp(){
            let i=$(idBtnOperation).data('it');
            if((i+1)<ops.length){
                $(idBtnOperation).data('it',i+1);
                return ops[i+1];
            }
            else{
                $(idBtnOperation).data('it',0);
                return ops[0];
            }

        }

        function run(){
            let idElement =$(idBtnOperation).data('id-element');
            let i=$(idBtnOperation).data('it');
            let text=(ops[i].text!='=')
                         ? ($(idInputMin).val()+" " +ops[i].text+" "+$(idInputMax).val())
                         : ($(idInputMax).val());
            if($(idCkeck).prop('checked') && ($(idInputMax).val() || $(idInputMin).val()) ){
                let min = $(idInputMin).val();
                if(ops[i].op_name=='egal')
                    min=$(idInputMax).val();
                let value={
                    'op_name':ops[i].op_name,
                    'max':$(idInputMax).val(),
                    'min':min+'',
                };

                $.pushFilterToSearch(idSearch,idElement,idCkeck,name,value,label,text);
            }
            else{

                if($("#"+idElement)){
                    $.removeFilterToSearch("#"+idElement,idSearch);
                }
            }
        }

        $(idCkeck).on('change',function(){
            run();
        });
        $(idInputMax+','+idInputMin).on('change',function(){
            run();
        });


        //lorqu on clique sur le btn
        $(idBtnOperation).on('click',function(){
            let op = nextOp();
            $(this).html(op.text);
            if(op.text=='='){
                $(idInputMin).hide();
            }
            else{
                $(idInputMin).show();
            }
            run();
        });





    }

});
</script>
@endpush
@endonce

@push('script')
<script>
    $(function(){
        $.addFilterNumber(
                      "#{{ $id }}",
                      "{{ $ligne->label }}",
                      "{{ $ligne->name }}",
                      "#{{ $ligne->idSearch}}",
                      "#{{ $idCkeck }}",
                      "#{{ $idInputMin }}",
                      "#{{ $idInputMax }}",
                      "#{{ $idBtnOperation }}",
                      "{{ $ligne->op }}");
    });

</script>

@endpush
@endif
