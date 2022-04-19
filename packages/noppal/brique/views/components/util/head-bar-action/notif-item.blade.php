<div class="c-notif-item d-flex  py-2 pt-3 border "  >
    <div class="text-center  text-align-center" style="min-width: 40px;">
        <i class="material-icons-outlined md-24" style="width: 24px;">{{ $icon }}</i>
    </div>
    <div class="flex-npl::grow-1">
        <h6 class="mr-1 mb-1" >{{ $titre }}</h6>
        @if($image)
            <p class="mr-1">
                <img src="{{ $image }}" alt="">
            </p>
        @endif
        <p class="mr-1 mb-1 " >
            {{ $message }}
        </p>
        <p class="">
            <a href="{{ $link_url }}" class="lien-sp" >
                {{ $link_name }} > 
            </a>
        </p>
    
    </div>
</div>