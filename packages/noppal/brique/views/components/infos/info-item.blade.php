@if(!$attributes['couleur'])
    @props(['couleur'=>'#007bff'])
@elseif($attributes['couleur']=='success')
    @props(['couleur'=>'var(--success)'])
@elseif($attributes['couleur']=='warning')
    @props(['couleur'=>'var(--warning)'])
@elseif($attributes['couleur']=='danger')
    @props(['couleur'=>'var(--danger)'])
@endif
<li class="info-item list-group-item d-flex align-items-center " style="padding:8px 10px;">
    @if ($attributes['icon'])
        <div>
            <i class=" @if($attributes['typeIcon']){{ $attributes['typeIcon'] }} @else material-icons  @endif md-32 mr-3" style="color:#6c757d;">
                {{ $attributes['icon'] }}
            </i>
        </div>
    @endif

    <div class="">

        <div class="" style="font-size: 14px;">
            @empty ($link)
                <span style="color: {{$couleur ?? ''}};" id="{{ $attributes['id_value'] }}">{{ $value }}</span>
            @else
                <a href="$link" style="color: {{$couleur ?? ''}};">{{ $value }}</a>
            @endif
        </div>
        @if (!empty($title))
            <div class="text-muted" style="font-size: 14px;">
                {{ $title }}
            </div>
        @endif

    </div>

</li>
