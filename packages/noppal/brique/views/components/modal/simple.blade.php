<div class="modal fade {{ $attributes['class'] }}" id="{{ $id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="{{ $id }}Label">{{ $titre }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="alert alert-primary" role="alert" id="{{ $id }}__alert" style="display: none;">
        </div>

        @if ($attributes['url'])
        <form  method="post" action="{{ $attributes['url'] }}" id="{{ $attributes['idForm'] }}" @if($attributes['enctype']) enctype="{{ $attributes['enctype'] }}" @endif>
             @csrf
        @endif

            <div class="modal-body">
              {{ $slot }}
            </div>
            <div class="modal-footer justify-content-between">
              <div>
                <div class="spinner-border text-primary" role="status" id="{{ $id }}__spinner" style="display: none;">
                  <span class="sr-only">Loading...</span>
                </div>
              </div>
              <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary mx-1" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary mx-1" id="">Valider</button>

                {{ $actions }}
              </div>


            </div>
        @if ($attributes['url'])
        </form>
        @endif
      </div>
    </div>
  </div>

  @push('script')
  <script>
      $(function(){
        let idForm="#{{ $attributes['idForm'] }}";
        let myAlert="#{{ $id }}__alert";
        // alert('ok');

        $('#{{ $attributes['idForm'] }}').on('submit',function(e){
            //alert($(idForm).prop('action'));
            let idAlert="#{{ $id }}__alert";
            e.preventDefault();
            $("#{{ $id }}__spinner").show();
            let form=$(idForm).get(0);
            let enctype=$(idForm).prop('enctype');
            let data=null;
            let contentType='application/x-www-form-urlencoded; charset=UTF-8';
            let processData=true;
            if(enctype=="multipart/form-data"){
                data= new FormData(form);
                contentType=false;
                processData=false;
            }
            else{
                data= $(idForm).serializeObject();
            }

            console.log(data);
            $.ajax({
                type: $(idForm).prop('method'),
                enctype: enctype,
                url: $(idForm).prop('action'),
                data: data,
                processData: processData,
                contentType: contentType,
                cache: false,
                timeout: 600000,

                beforeSend:function(){
                    $(idForm).find('.is-valid').removeClass('is-valid');
                    $(idForm).find('.is-invalid').removeClass('is-invalid');
                },
                success: function (response) {
                    console.log(response);
                    console.log(response.errors);
                    if(response.status){
                      $(idAlert).html(response.message);
                      $(idAlert).html(response.message);
                      //alerter(idAlert,response.message,'alert-success',1);
                      $(idForm).trigger('success',[response]);
                      $("#{{ $id }}").modal('hide');

                    }
                    else{
                      alerter(idAlert,response.message,'alert-danger');
                      for (const error in response.errors) {
                         var input = $(idForm).find('input[name="'+error+'"]');
                         input.addClass('is-invalid');
                         input.data('idMessage',error)

                         @if($attributes['activeMessage'])
                         let element = $("#form__message__"+error);
                         if(element){
                              element.addClass('invalid-feedback');
                              let text="";
                              for(const message of response.errors[error]){
                                text=text+' '+message;
                              }
                              element.html(text);
                              element.show();
                              console.log('active')
                         }

                         @endif
                      }
                      $(idForm).trigger('no-success');

                    }
                },
                error:function(err){
                  alerter(idAlert,"Impossible de joindre le serveur ou Erreur Traitement",'alert-danger');
                  $(idForm).trigger('error');

                },
                complete:function(){
                  $("#{{ $id }}__spinner").hide();
                }

              });

         });

        function alerter(idAlert,message,myclass,fade=0){
            $(idAlert).html(message);
            $(idAlert).prop('class',"alert "+myclass);
            $(idAlert).alert('show');
            $(idAlert).fadeIn();
            if(fade==1){
                  $(idAlert).delay(2000).fadeOut(500);
            }
        }

        $('#{{ $id }}').on('hidden.bs.modal', function (e) {
            $(myAlert).alert('close');


        });


      });
   </script>
  @endpush
