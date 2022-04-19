<button class="btn {{$class}}" id="{{$id}}" @if($data) data-info='{{$data}}'' @endif) >
    @if ($icon)
        <i class="material-icons md-14">{{ $icon }}</i>
    @endif
    {{$text}}
</button>