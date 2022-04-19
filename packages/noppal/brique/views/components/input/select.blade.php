<select name="{{ $name }}" id="{{ $attributes['id'] }}" 
        class="custom-select {{ $attributes['class'] }}" style="{{$attributes['style']}}"
        @if($attributes['required'] && $attributes['required']=='true')
                required 
        @endif
        @if($attributes['disabled'] && $attributes['disabled']=='true')
            disabled
        @endif
    >
    @foreach ($dt as $key=>$text )
        <option value="{{ $key }}" 
                @if ($key == $value) 
                    selected="true"
                @endif>
            {{ $text }}
        </option>
    @endforeach
</select>