@props(['parentMessageClass'=>'n__parent__message','elementMessageClass'=>'n__element__message'])
<button type="button" id="{{ $id }}" class="{{ $attributes['class'] }}"
        @if($attributes['activeOnModify'])
            disabled="disabled";
        @endif
        style="{{ $attributes['style'] }}" >
    @if (!empty($icon))
        <i class="material-icons mr-1 md-16 " >{{ $icon }}</i>
    @endif
    <span style="font-size: 14px;">
        {{ $text }}
    </span>
</button>


@push('script')
<script type="text/javascript">

$(document).ready(function(){

    var idForm= '#'+'{{ $idForm }}';
    var id = '#'+'{{ $id }}';
    var can_send=true;
    function jeton(){
        $(id).one('click',async function(e){
            e.preventDefault();
            document.getElementById('{{ $id }}').disabled=true;
            if(can_send){
                can_send=false;
                document.getElementById('{{ $id }}').disabled=false;
                $(idForm).submit();
            }
            else{
                e.stopPropagation();
            }
            
            
            
            e.stopImmediatePropagation() ;


         });
    }
    jeton();

    $(idForm).submit(function (e) {
        console.log($(this).serialize());
        e.preventDefault();
        let form=$(idForm).get(0);
        console.log(form);
        let enctype=$(this).attr('enctype');
        console.log(enctype);
        let data=null;
        let contentType='application/x-www-form-urlencoded; charset=UTF-8';
        let processData=true;
        if(enctype=="multipart/form-data"){
            data= new FormData(form);
            contentType=false;
            processData=false;
        }
        else{
            data= $(this).serializeObject();
            console.log(data);
        }

        console.log(data);
        $.ajax({
            type: $(this).attr('method'),
            enctype: enctype,
            url: $(this).attr('action'),
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
                    alerter(response.message,'alert alert-success','alert alert-danger',1);
                    @if($attributes['isReset'])
                        $(idForm)[0].reset();
                    @else
                        @if($attributes['hrefId'])
                            window.location.href = "{{ url($attributes['hrefId']) }}"+'/'+response.id;
                        @elseif ($attributes['href'])
                            window.location.href = "{{ url($attributes['href']) }}";
                        @endif
                    @endif

                    @if ($attributes['update_id'])
                        $('#{{ $attributes["update_id"] }}').val(response.id);
                    @endif

                    @if ($attributes['activeOnModify'])
                        $(id).prop('disabled',true);
                    @endif

                    $(form).trigger('success',response);
                }
                else{
                    alerter(response.message,'alert alert-danger','alert alert-success');
                   //
                   for(let item in response.errors){
                       console.log(item);
                       console.log(response.errors[item]);
                   }

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

                        
                    }
                    resetAlert();
                    jeton();
                   
                    // let idContentAlert = '#'+'{{ $idContentAlert }}';
                    // $(idContentAlert).html(response.message)
                    // $(idContentAlert).removeClass('alert-success');
                    // $(idContentAlert).removeClass('alert-danger');
                // }
            },
            error: function(error){
                console.log(error);
                jeton()
            },
            complete:function(complete){
                can_send=true;
            }

        });

        function alerter(message,typeClass,removeClass,fade=0){
            var idContentAlert= '#'+'{{ $idContentAlert }}';
            $(idContentAlert).removeClass(removeClass);
            $(idContentAlert).html(message);
            $(idContentAlert).addClass(typeClass);
            $(idContentAlert).fadeIn();
            if(fade==1){
                $(idContentAlert).delay(2000).fadeOut(500);
            }

        }

        function resetAlert(){
            $(idForm).find('.is-valid, .is-invalid').on('keyup change',function(e){
                console.log('resetAlert');
                @if($attributes['activeMessage'])
                    let element = $("#form__message__"+$(this).data('idMessage'));
                    if(element){
                        element.html('');
                    }
                @endif
                $(this).removeClass('is-valid is-invalid');
            });
        }



    });

    @if ($attributes['activeOnModify'])
        $(idForm+" :input").on('change',function(){
            if($(this).prop('name'))
                $(id).prop('disabled',false);
        });
   @endif




});

</script>
@endpush
