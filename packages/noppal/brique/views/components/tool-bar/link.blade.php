@if(!isset($attributes['canAccess']))
    @props(['access'=>true])
@elseif( \App\Util\Access::canAccessRaw($attributes['canAccess']) ) 
    @props(['access'=>true])
@else
    @props(['access'=>false])
@endif


@if($access)

<a class="btn_tb btn btn-sm {{ $attributes['evidence'] }} d-flex align-items-center  mr-3 {{ $attributes['class'] }}" id="{{ $id }}" href="{{ $url }}">
    @if($attributes['icon'])
        <i class="tb-btn-icon material-icons-outlined " >{{ $attributes['icon'] }}</i>
        <span class="tb-btn-text ml-1"> {{ $text }}</span>    
    @else
        <span class="tb-btn-text-u"> {{ $text }}</span>    
    @endif
</a>
@endif