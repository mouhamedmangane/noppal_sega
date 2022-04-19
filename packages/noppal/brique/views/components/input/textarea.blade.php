<textarea  
        name="{{ $name }}" 
        id="{{ $attributes['id'] }}" 
        class="form-control @if ($attributes['sm']) form-control-sm @endif {{ $attributes['class'] }}"
        @if($attributes['required'] && $attributes['required']=='true')
                required 
        @endif
        rows="{{ $attributes['rows']  }}"
        cols="{{ $attributes['cols']  }}"
        placeholder="{{ $attributes['placeholder'] }}"
        style="{{ $attributes['style'] }}">{{ $value}}</textarea>