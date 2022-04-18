@once


 @push('script')
<script>
$(function(){
    $.fn.nplModalConfirm = function(options){
        let html='\
        <div class="modal fade" id="'+options.id+'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">\
            <div class="modal-dialog modal-dialog-centered" role="document">\
                <div class="modal-content '+options.type+'">\
                    <div class="modal-header">\
                        <h5 class="modal-title" id="exampleModalLongTitle">'+options.title+'</h5>\
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
                            <span aria-hidden="true">&times;</span>\
                        </button>\
                    </div>\
                    <div class="modal-body">\
                        '+options.text+'\
                    </div>\
                    <div class="modal-footer">\
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="'+options.id+'__btn_close">Annuler</button>\
                        <button type="button" class="btn btn-primary" id="'+options.id+'__btn">Confirmer</button>\
                    </div>\
                </div>\
            </div>\
        </div>\
        ';
        $('body').append(html);
        $('#'+options.id+'__btn').on('click',function(){
            options.fonction(options.data);
        });
        $('#'+options.id).on('shown.bs.modal',function(){
            $("#"+options.id+'__btn').focus();
        });
        return $('#'+options.id);
    };
});
</script>      
@endpush
@endonce