
@if(isset($attributes['id_value']))
    @props(['id_value_var'=>$attributes['id_value']])
@else
    @props(['id_value_var'=>Npl\Brique\ViewModel\GenId::newId()])
@endif




<tr style="line-height: 50%" >
    <td   @if ($attributes['ligneEntiere'])
            style="font-size:15px;height: 31px; vertical-align:middle;"
            class="font-weight-bold liste-simple-key"
        @else
            style="@if(!$attributes['e-badge']) width:40%;vertical-align:middle;@endif"
            class="text-muted liste-simple-key"
        @endif
        >
        {{ $key }}
    </td>
    <td  style=" vertical-align:middle;" @if($attributes['ligneEntiere']) class="" @endif>
        @if($attributes['valueType']=='boolean')
            <x-npl::input.checkbox id="{{$id_value_var}}" name="Npl\Brique\ViewModel\GenId::newId()" :checked="$value" disabled="disabled" />
        @else
            <span class="font-weight-bold" id="{{$id_value_var}}" style="font-size:15px ">{{ $value }}</span>
        @endif
        @if (isset($valuee))
            {{$valuee}}
        @endif
        @if ($attributes['i-Badge'])
            <span class="badge badge-primary ml-1 ">{{$attributes['i-Badge']}} </span>
        @endif
    </td>
    @if ($attributes['e-badge'])
        <td style=" vertical-align:middle;">
            <span class="badge badge-primary ">{{$attributes['e-badge']}} </span>
        </td>
    @endif
</tr>
