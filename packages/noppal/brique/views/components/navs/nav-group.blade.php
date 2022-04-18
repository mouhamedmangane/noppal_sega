
@props(['id' => Npl\Brique\ViewModel\GenId::newId(),])
<li class="nav-v-item nav-v-group position-relative @if($active) active-group @endif  ">
    <a href="#navdown{{ $id }}" data-toggle="collapse" aria-expanded="false"
        class="d-flex pr-3  nav-v-item-link @if($active) active @endif "
        style="position: relative;">
        <span class="nav-v-item-container-icon">
            <i class="material-icons-outlined nav-v-icon" style="">{{ $icon }}</i>
        </span>
        <span class="flex-grow nav-v-item-link-title">{{ $name }}</span>
        <span style="justify-self: flex-end;">
            <i class="material-icons-outlined  ml-2 nav-v-item-link-plus d-inline-block" style="">
                expand_more
            </i>
        </span>

    </a>
    <ul class="list-unstyled components-group collapse @if($active) show @endif  " id="navdown{{$id}}" style="">
        @foreach ($navElementModels as $navElementModel)
            @if($navElementModel->droit)
                @if ($isNavItemModel($navElementModel))
                    <x-npl::navs.nav-item :name="$navElementModel->name" :url="$navElementModel->url" :icon="$navElementModel->icon" :active="$navElementModel->active"  />
                @elseif ($isNavGroupModel($navElementModel))
                    <x-npl::navs.nav-group :name="$navElementModel->name" :navElementModels="$navElementModel->navElementModels" :icon="$navElementModel->icon" />
                @endif
            @endif
        @endforeach
    </ul>

</li>
