<li class="nav-v-item ">
    <a href="{{ $url }}" 
        class=" {{ ((Request::is($url))?'active':null) }} d-flex border-0"
        style="position: relative;">

        <span class="trait-vertical rounded  style="position: absolute;top:0px;left:0px;height:100%;width:2px;"></span>
        <span class="nav-v-item-container-icon">
            <i class="material-icons-outlined nav-v-icon " style=";">{{ $icon }}</i>
        </span>
        <span class="" style="margin: 0px 2px;">
            {{ $name }}
        </span>

    </a>
</li>