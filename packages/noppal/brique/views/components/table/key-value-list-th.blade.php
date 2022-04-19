<tr style="line-height: 50%;font-size:11px;" class="text-muted font-weight-lighter"  >
    <th style="@if(!$attributes['badge']) width: 50%;@endif">
        <span class="font-weight-lighter">{{ $key }}</span>
    </th>
    <th>
        <span class="font-weight-lighter">{{ $value}}</span>
    </th>
    @if ($attributes['badge'])
        <th>{{$attributes['badge']}}</th>
    @endif
</tr>
