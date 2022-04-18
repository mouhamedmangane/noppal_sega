<div class="title-bar d-flex align-items-center w-100 justify-content-between pl-3 mt-1 my-sm-0 flex-wrap-sm" style="" id="bloc-titre-page">
    <div class="d-flex align-items-center my-2 n-col-sm-12 masque-sm" id="titre_page" style="">
        <div  class="bg-primary text-white rounded-circle border  text-align center d-flex align-items-center justify-content-center masque-sm" 
        style="width: 35px; height: 35px;@if ($attributes['img'])border-color:black!important;@endif">
            {{ $image }}
        </div>
        {{ $slot }}
    </div>
    <div class="flex-grow-1 d-flex aligns-items-center  justify-content-end  title-bar-right" style="">
        {{ $right }}
    </div>
</div>

@once
@push("script")
<script>
    $(function(){
        function titre(){
            var newWidth = window.innerWidth;
            var newHeight = window.innerHeight; 
            if(newWidth<=768){
                if(!$("#titre_page").hasClass("deplacer")){
                    // alert('ok');
                    $('#titre_page').removeClass('masque-sm');
                    $('#titre_page').addClass('deplacer my-sm-0 nowrap');
                    $("#name_app_bloc").get(0).append($('#titre_page').get(0));
                    $("#name_app").hide();
                }
            }
            else{
                if($("#titre_page").hasClass("deplacer")){
                    $('#titre_page').removeClass('deplacer my-sm-0');
                    $('#bloc-titre-page').get(0).prepend($('#titre_page').get(0));
                    $("#name_app").show();

                }
            }
        }
        titre();
        window.addEventListener('resize', function(event){
            titre()
        });
    });
</script>
@endpush    
@endonce