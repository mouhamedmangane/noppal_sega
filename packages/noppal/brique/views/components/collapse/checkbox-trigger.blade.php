
<x-npl::input.checkbox :id="$id"
                          type="switch" 
                          :url="$attributes['url']"
                          :data="['idContent'=>'$idContent']"
                          class="{{ $attributes['class'] }} checkbox-collapse-trigger" 
                          :checked="$checked"/>
@once
@push('script')
<script>
$(function(){
    $('.checkbox-collapse-trigger').on('change',function(){
        let idContentCollapse= $(this).data('idContent');
        let checked = $(this).checked();
        if(checked){
            $("#"+idContentCollapse).collapse("show");
        }
        else{
            $("#"+idContentCollapse).collapse("hide");
        }

    });
});
</script>
@endpush
@endonce