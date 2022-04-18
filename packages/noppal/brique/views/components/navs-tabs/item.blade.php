<li class="nav-item" role="presentation"  >
    <a class="nav-link @if ($active) active @endif {{ $attributes['classLink'] }} " 
    id="{{ $id }}" 
        data-toggle="tab" 
        href="#{{ $idPane }}" 
        role="tab" 
        aria-controls="home" 
        aria-selected="true">
        @if($attributes['icon']) 
            <i class="{{$attributes['icon']}} "></i>
        @endif

        {{ $text }}
        @if(!empty($badge))
            <span class="badge @if(!empty($badgeType)) {{ $badgeType }} @endif">{{ $badge }}</span>    
        @endif
        {{ $slot }}
     
    </a>
</li>