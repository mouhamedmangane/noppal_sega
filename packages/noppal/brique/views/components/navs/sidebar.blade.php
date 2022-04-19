<div class="border-right @if($active) {{ $id }}-toggle @endif" id="{{ $id }}" style="">
    <button class=" btn btn-default  nav-v-item-container-icon mt-2 " id="toggle-{{ $id }}">
        <i class="material-icons nav-v-icon" >menu</i>
    </button>
    <x-npl::navs.nav :navModel="$model" class="bg-green" />
</div>

@once
    @push('script')
        <script type="text/javascript">
            $(document).ready(function()
            {

                $('#toggle-{{ $id }}').on('click',function(){
                    toggle='on';
                    if($("#{{ $id }}").hasClass('{{ $id }}-toggle')){
                        toggle='off';
                    }
                    $.ajax({
                        type: "get",
                        url: '{{ url("toggle_sidebar")}}',
                        data: {
                            'active':toggle
                        },
                        dataType: "dataType",
                        success: function (response) {

                        }
                });
                $("#{{ $id }}").toggleClass('{{ $id }}-toggle');


                });

            });

        </script>

    @endpush
@endonce
