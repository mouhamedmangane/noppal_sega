@if (!empty($attributes['id']))
    @props(['idd'=> $attributes['id']])
@else
    @props(['idd'=>Npl\Brique\ViewModel\GenId::newId()])
@endif

<select  id="{{ $idd }}" 
        class="n-select-link {{ $attributes['class'] }} border-none  n-col-sm-12 "
        data-content-cible="{{ $contentCible }}" >
    @foreach ($dt as $key=>$item )
        @if($key=="d")
           
        @else
            <option value="{{ $key }}"
                    class="n-select-link-item" 
                    @if ($key == $value) 
                        selected="true"
                    
                    @endif>            
                    {{ $item}}
            </option>
        @endif
    @endforeach
</select>


@once
@push('script')
    <script>
        $(document).ready(function(){
            let n_select_link_on_change =function (select_link_jq){
                $('#'+select_link_jq.data("content-cible")).css("position",'relative');
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "get",
                    url: select_link_jq.val(),
                    dataType: "text",
                    beforeSend:function(){
                        $('#'+select_link_jq.data("content-cible")).loading();
                    },
                    success: function (response) {
                        let idContent = select_link_jq.data("content-cible");
                        $('#'+idContent).html(response);
                    },
                    error:function(){
                        $("#"+select_link_jq.data("content-cible")).try_component(function(){
                            n_select_link_on_change(select_link_jq);
                        });
                    }
                });
            }
            $(".n-select-link").on('change',function(){
                n_select_link_on_change($(this));
            });
        });
    </script>
        
@endpush
@endonce