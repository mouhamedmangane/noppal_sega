@props(['dispo'=>"Positionner sur l'image pour la changer ou la supprimer",
        'no_dispo'=>"Positionner sur l'image pour la changer"])
<div class="d-flex align-items-center flex-wrap-sm">
    <div style="width: {{ $x }}px; height:{{ $y }}px;background-size:{{ $x-10 }}px {{ $y-10 }}px;"
         class="border rounded input-img-content @if($attributes['circle']) rounded rounded-circle @endif">

         <img src="{{ $url }}"
              id="{{ $id }}-image"
              alt="Image du produit "
              class="input-img rounded @if($attributes['circle']) rounded rounded-circle @endif"
              style="@if (empty ($url)) display:none;@endif">

        @if($attributes['activeAction']!='false')
        <div class="input-img-action" >
                <input type="file"
                       accept="image/png, image/jpeg"
                       class="border rounded"
                       name="{{ $name }}"
                       id="{{ $id }}"
                       style="display: none;">
                <button class="btn btn-sm btn-primary" type="button" style="padding:2px 5px;" id="{{ $id }}-edit" >
                    <i class="material-icons md-14" >edit</i>
                </button>

                <button class="btn btn-sm btn-success npl__open-images" type="button" style="padding:2px 5px;" id="{{ $id }}-open" data-idimg="{{$id}}" data-src="{{$url}}" >
                    <i class="material-icons md-14" >open_in_new</i>
                </button>
                
        </div>
        @endif
    </div>
    
    <div style=" @if($attributes['activeText']=='false') display:none; @endif "
             id="{{ $id }}-text"
             class="input-image-text"
            >
                    @if (empty($url))
                        {{ $no_dispo }}
                    @else
                        {{ $dispo }}
                    @endif
    </div>
</div>


@push('script')
<script>
    $(document).ready(function(){
        $("{{ ($attributes['idTriggerEdit']) ? '#'.$attributes['idTriggerEdit']:'' }}").click(function(){
            $("#{{ $id }}").trigger('click')
        });
        $("#{{ $id }}").on('change',function(e){
            console.log('change');
            var file = $(this)[0].files[0];
            if($(this).val()!=""){

                $("#{{ $id }}-image").attr('src',URL.createObjectURL(file));
                $("#{{ $id }}-image").show();
                $("#{{ $id }}-text").html('{{ $dispo }}');
            }

        });
        $("#{{ $id }}-edit").on('click',function(e){
            console.log('change2');
            $("#{{ $id }}").trigger('click');
        });
        $("#{{ $id }}-sup").on('click',function(e){
            console.log('change2');
            $("#{{ $id }}").val('');
            $("#{{ $id }}-image").hide();
                $("#{{ $id }}-text").html('{{ $no_dispo }}');
                $("#{{ $id }}-image").attr('src','');
        });
    });
</script>
@endpush


@once
    

@push('modal')
<!-- Large modal -->

<div id="npl__dialog_open_image" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Photo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body d-flex justify-content-center">
            <img src="" alt="" width="80%" id="npl__show_image_modal">
          </div>
          {{-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div> --}}
          ...
      </div>
    </div>
  </div>
<!-- Small modal -->

@endpush


@push('script')
<script>
    $(function(){
        $('.npl__open-images').on('click',function(){
            let url= $(this).data('src');
            let id= $(this).data('idimg');
            console.log(id);

            let img=$("#"+id+"-image");;
            
            if(img){
                $("#npl__show_image_modal").attr('src',img.attr('src'));
            }
            console.log($("#npl__dialog_open_image").html());
            $("#npl__dialog_open_image").modal('show');
            $("#npl__dialog_open_image").modal('show');
            
        });
    });
</script>
@endpush
    
@endonce
