
@if($attributes['id'])
    @props(['idd' => $attributes['id']])
@else
    @props(['idd' => Npl\Brique\ViewModel\GenId::newId()])
@endif

<div class="d-flex align-items-center">

@if ($attributes['prev'])
    <span class="d-inline-block mr-2">{{ $attributes['prev'] }}</span>
@endif

<div class="custom-control  custom-switch custom-control-inline" class="">
 
    <input  type="checkbox"
            name="{{ $name }}"
            value="{{ $value }}"
            id="{{ $idd }}"
            @if ($attributes['disabled'])
                disabled="disabled"
            @endif
            @if ((is_string($attributes['checked']) && $attributes["checked"]=='true') || (!is_string($attributes['checked']) && $attributes["checked"]))  checked="{{ $attributes['checked'] }}"  @endif
            class=" @if ($attributes['type'] == 'switch') custom-switch @else custom-checkbox @endif
                    custom-control-input {{ $attributes['class'] }}"
            @isset($attributes['data'])
                @foreach ($attributes['data'] as $key=>$value ) data-{{ $key }}="{{ $value }}" @endforeach
            @endisset
    >

    <label for="{{ $idd }}" class="custom-control-label">
    </label>

</div>

@if ($attributes['next'])
    <span class="d-inline-block ">{{ $attributes['next'] }}</span>
@endif
</div>