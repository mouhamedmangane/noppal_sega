@props(['idInput'=>Npl\Brique\ViewModel\GenId::newId()])

<button type="button" class="btn-scroll btn-scroll-left  btn btn-primary btn-default btn-sm px-0"><</button>
<form class="position-relative search-filter scrollable no-scrollbar  n-col-sm-12 flex-wrap-sm overflow-sm-hidden border px-1 rounded "
      id="{{ $id }}__form_search"
      style="overflow-x: auto!important;padding-right:20px;"  >

    <div  id="{{ $id }}" class="d-flex align-items-center flex-grow-1 idSearch n-col-sm-12 flex-wrap-sm  ">

    </div>

    <div class=" position-relative n-col-sm-12" style="order:2;">
        <input type="text" name="{{ $name }}"
                class="form-control flex-grow-1  search-input  n-max-width-sm-content search-search border-0"
                placeholder="Rechercher" id="{{ $idInput }}">
        <i class="material-icons text-muted position-absolute" style="top:6px;right: 10px;color:#dee2e6;">search</i>

    </div>
</form>
{{-- <span class="ml-1"></span> --}}

<button type="button" class="btn-scroll btn-scroll-right btn btn-primary btn-default btn-sm px-0">></button>


@once
@push('script')
<script>
$(function(){
    let timeout = null;

    $(".btn-scroll").hide();
    $(".idSearch").on("n-resize",function(){
        console.log($(this).parent()[0].scrollWidth);
        console.log($(this).parent()[0].offsetWidth);
        if($(this).parent()[0].scrollWidth > $(this).parent()[0].offsetWidth){
            $(this).parent().siblings(".btn-scroll").show();
            $(this).parent().scrollLeft($(this).get(0).clientWidth);
        }
        else{
            $(this).parent().siblings(".btn-scroll").hide();
        }
    });
    function onPressBtnScroll(btnJQ){
        let pas = 20;
        let scroll =$(btnJQ).siblings('.scrollable').scrollLeft();
        let otherclasse="";
        let condition=false;
        let valueisCondition = scroll;
        let valueisNotCondition = scroll;
        if($(btnJQ).hasClass('btn-scroll-left')){

            otherclasse="btn-scroll-right";
            condition =(scroll - 20 )<=0;
            valueisCondition = 0;
            valueisNotCondition= scroll - pas;
        }
        if($(btnJQ).hasClass('btn-scroll-right')){
            let clientWidth = $(btnJQ).siblings('.scrollable').get(0).scrollWidth - $(btnJQ).siblings('.scrollable').get(0).clientWidth;
            console.log(clientWidth+' et '+scroll+" "+$(btnJQ).siblings('.scrollable').get(0).scrollWidth);

            otherclasse="btn-scroll-left";
            condition =(scroll + pas ) >= clientWidth;
            valueisCondition = clientWidth;
            valueisNotCondition= scroll + pas;
        }

        if(condition){
            clearInterval(timeout);
                $(btnJQ).prop('disabled',true);
                $(btnJQ).siblings('.scrollable').scrollLeft(valueisNotCondition);
        }
        else{
                $(btnJQ).siblings('.scrollable').scrollLeft(valueisNotCondition);
        }
        $(btnJQ).siblings('.'+otherclasse).prop('disabled',false);

    }
    $(".btn-scroll").on('mousedown',function(event){
        if(event.which===1){
            timeout =  setInterval(onPressBtnScroll, 100,this);
        }
    });

    $(".btn-scroll").on('mouseup',function(event){
        clearInterval(timeout);
    });

    $('.search-search').on('focus',function(){

        $(this).parent().parent().addClass('search-form-focus ');
    });
    $('.search-search').on('blur',function(){

        $(this).parent().parent().remove('search-form-focus');
    });

});
</script>
@endpush
@endonce

@push('script')
    <script>
        $(function(){
            @if($dataTableId && !empty($dataTableId))
            $('#{{ $idInput }}').on('keyup',function(event){
                //  console.log($('#{{ $id }}__form_search').serializeObject());
                let dataTable = $('#{{ $dataTableId }}').DataTable();
                $.chargement();
                dataTable.ajax.reload();
            });
             @endif
             $('#{{ $id }}__form_search ').find('.idSearch').on('n-resize',function(){
                $('#{{ $dataTableId }}').DataTable().ajax.reload();
             });
        });
    </script>
@endpush
