<button class="{{ $attributes[class]}}" id="{{ $id }}">
    @if (!empty($icon))
        <i class="material-icons">{{ $icon }}</i>
    @endif
    <span>
        {{ $text }}
    </span>
</button>

@push('script')

<script type="text/javascript">
    $(document).ready(function(){
        let id = '#'+{{ $id }};
        $(id).on('click',funciton(){
            history.back();
        });
    });
</script>

@endpush