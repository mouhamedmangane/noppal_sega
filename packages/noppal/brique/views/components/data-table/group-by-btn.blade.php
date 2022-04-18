<x-npl::input.d-d-radio :id="$id" 
                           name="groupby_prod_tb" 
                           :label="$label" 
                           :dt="$dt" 
                           :defaultSelected="$defaultSelected"
                           :dataSave="['idtable'=>$idDataTable]"
                           class="{{ $attributes['class'] }} group-by-btn"
                           classRadio="{{ $attributes['classRadio'] }} group-by-btn-item"
                           classLabel="{{ $attributes['classLabel'] }}"
                           />


@once
@push('script')
<script>
    $(function(){
        $('.group-by-btn-item').on('change',function(){
            let checked=$(this).prop('checked');
            if(checked){
                let idDataTable=$(this).parent().data('idtable');
                if(idDataTable){
                    let value=$(this).val();
                    table=$('#'+idDataTable).DataTable();
                    if(!value || value.length<=0){
                        table.rowGroup().disable();
                        //table.ajax.reload();
                        $('#'+idDataTable).children('tbody').children('tr').show();
                        table.draw();
                    }
                    else{
                        table.rowGroup().enable().draw();
                        table.rowGroup().dataSrc($(this).val());
                    }
                    
                }
            }
        })
    });
</script>
@endpush
@endonce