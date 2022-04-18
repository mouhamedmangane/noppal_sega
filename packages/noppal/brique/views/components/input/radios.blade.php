
@foreach ($dt as $key=>$item)
    @if($attributes['encapsuler']) <div class="{{ $attributes['classEncapsuler'] }}"> @endif
    <div      
              @if ($attributes['dataSave'])
                    @foreach($attributes['dataSave'] as $k => $val)
                        data-{{ $k }}="{{ $val }}"
                    @endforeach
              @endif
                
    
                class="custom-control {{  $attributes['class'] }}
                @if ($attributes['type'] == 'switch') 
                    custom-switch
                @else
                    custom-radio
                @endif custom-control-inline  ">
       
        <input  type="radio" 
                name="{{ $name }}"
                value="{{ $key }}"
                @if($key == $attributes['defaultSelected'])
                    checked
                @endif
                id="{{ $attributes['id']}}-{{ $key}}" 
                class="custom-control-input {{ $attributes['classRadio'] }}" 
                @if ($key == $value) 
                    checked="true" 
                @endif  
        >    
       
        <label for="{{ $attributes['id']}}-{{ $key}}" class="custom-control-label {{ $attributes['classLabel'] }}">{{ $item }}</label>

    </div>
    @if($attributes['encapsuler']) </div> @endif
@endforeach