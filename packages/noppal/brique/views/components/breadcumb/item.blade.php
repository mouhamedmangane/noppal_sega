<li class="breadcrumb-item @if($attributes['active']) active text-body @endif {{ $attributes['class'] }}" 
    style="{{ $attributes['style'] }}"
    aria-current="{{ $attributes['aria-current'] }}">
    {{ $slot }}
</li>