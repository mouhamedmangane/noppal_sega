
<a href="{{ $url }}" class="{{ $class }}"> 
    @if(isset($src) && !empty($src))
        <x-npl::images.small :src="$src" />
    @endif
    @if(isset($icon) && !empty($icon))
        <i class="material-icons md-14">{{ $icon }}</i>
    @endif
    @if(isset($text) && !empty($text))
        <span class="d-inline-block ml-1">{{ $text }}</span> 

    @endif

</a>