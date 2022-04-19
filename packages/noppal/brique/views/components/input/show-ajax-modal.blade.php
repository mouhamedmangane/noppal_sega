<div data-url="{{ $url }}" data-idmodal="{{ $idModal }}" class="show-ajax-modal {{ $attributes['class'] }}" >
    {{ $slot }}
</div>

@once
    

@push('script')
<script>
$(function(){
    $('.show-ajax-modal').on('click',function(){
        let url=$(this).data('url');
        let idModal=$(this).data('idmodal');
        if($('#'+idModal).length){
            $('#'+idModal).modal('show');
        }
        else{
            $.chargement();
            $.ajax({
                type: 'get',
                url: url,
                dataType: "html",

                success: function (response) {
                    $.rmchargement();
                    $(document.body).append(response);
                    $('#'+idModal).modal('show');
                },
                error:function(err){
                    $.rmchargement();
                    alert('echec chargment du modal impossible de joindre le serveur');

                }
            });
        }
    })
});
</script>
@endpush

@endonce