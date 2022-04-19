@if(!isset($attributes['canAccess']))
    @props(['access'=>true])
@elseif( \App\Util\Access::canAccessRaw($attributes['canAccess']) ) 
    @props(['access'=>true])
@else
    @props(['access'=>false])
@endif

@if($access)

<button class=" btn btn-sm {{ $attributes['evidence'] }} d-flex align-items-center  mr-3 {{ $attributes['class'] }}" 
        id="{{ $id }}" 
        @if($attributes['disabled']) disabled="{{ $attributes['disabled'] }}" @endif>
    @if($attributes['icon'])
        <i class="material-icons-outlined " style="font-size:16px;">{{ $attributes['icon'] }}</i>
        <span class="ml-1"> {{ $text }}</span>    
    @else
        <span class=""> {{ $text }}</span>    
    @endif
</button>

@push('script')
<script>
$(function(){
    $("#{{ $id }}").on('click',function(){
        let idAlert='{{ $attributes['idAlert'] }}';
        $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });     
        $.ajax({
            type: "{{ $method }}",
            url: "{{ $url }}",
            data:@json($dt),
            dataType: "json",
            success: function (response) {
                              
                if(response.status){
                    $.fn.nplAlertShow(idAlert,response.message,'alert alert-success','alert alert-danger',2.5);
                    @if ($attributes['redirect'])
                        window.location.href = "{{ url($attributes['redirect']) }}";
                    @elseif($attributes['redirectId'])
                        window.location.href = "{{ url($attributes['redirectId']) }}"+'/'+response.id;
                    @endif
                }
                else{
                    $.fn.nplAlertShow(idAlert,response.message,'alert alert-danger','alert alert-success',2.5);
                }

            },
            error: function(error){
                $.fn.nplAlertShow(idAlert,'Impossible de join de serveur','alert alert-danger','alert alert-success',2.5);

            }
        });
    })
});
</script>    
@endpush

@endif