<div class="c-head-button {{ $attributes['class'] }} position-relative">
    <button class="{{ $attributes['classBtn'] }} @if(!empty($idContent)) action-btn @endif" 
            @if(!empty($idContent))data-idcontent="{{ $idContent }}"@endif>
        
        @if(!empty($icon))<i class="material-icons-outlined ">{{ $icon }}</i>@endif
        
        {{ $slot }}



    </button>
    @if($attributes['badge'])
        <div class="c-head-message badge rounded-pill @if($attributes['badgeColor']) {{ $attributes['badgeColor'] }} @else bg-danger @endif">
            {{ $attributes['badge'] }}
        </div>
     @endif
</div>