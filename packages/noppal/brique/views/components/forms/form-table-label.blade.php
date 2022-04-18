<span class="d-flex w-100 ">

    <span class="flex-grow-1">{{ $labelText }}
        @if ($required && $required=='true')
            <span class="text-danger ml-1" style="justify-self: flex-end;"> * </span>
        @endif
    </span>
    @if(!$attributes['disposition'] && $attributes['dispositon']!='block' )
        <div style="justify-self: flex-end; ml-1">&nbsp;: </div>
    @endif

</span>