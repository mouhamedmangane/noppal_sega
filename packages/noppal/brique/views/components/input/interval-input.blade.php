
@if (!empty($attributes['id']))
    @props(['idd'=> $attributes['id']])
@else
    @props(['idd'=>Npl\Brique\ViewModel\GenId::newId()])
@endif

<div>
    <div>
        <x-npl::input.radios name="{{ $name }}__radio"
                            :dt="$radioData"
                            :value="$type"
                            id="{{ $idd}}__radio"
                            />
    </div>
    <div class="d-flex align-items-center" >
        <div id="{{ $idd }}__min__content" class="mt-2 flex-grow-1">
            <x-npl::input.text :name="$name.'_min'" type="number"
                                  id="{{ $idd }}__min"
                                  :placeholder="($type == 'fixe')?$attributes['placeholder']:'min'"
                                  :value="$minValue"
                                  :required="$attributes['required']"
                                  />
        </div>
        <div class="mx-2" id="{{ $idd }}__seperateur" @if($type=='fixe') style="display: none"  @endif>:</div>
        <div id="{{ $idd }}__max__content"
             class="mt-2 flex-grow-1"
             @if($type=='fixe') style="display: none"  @endif >


            <x-npl::input.text :name="$name.'_max'" type="number" id="{{ $idd }}__max"  placeholder="max" :value="$maxValue" />
        </div>

    </div>
</div>

@push('script')

<script >
    $(document).ready(function(){

        $("input[name='{{ $name }}__radio']").on("change",function(e){
              let type= $("input[name='{{ $name }}__radio']:checked").val();
              if(type =='fixe'){
                  $('#{{ $idd }}__max__content').hide();
                  $("#{{ $idd }}__min").attr('placeholder','{{ $attributes['placehoder'] }}')
                  $("#{{ $idd }}__seperateur").hide();
              }
              else{
                  $('#{{ $idd }}__max__content').show();
                  $("#{{ $idd }}__min").attr('placeholder','min');
                  $("#{{ $idd }}__seperateur").show();

              }
        });
    });
</script>
@endpush
