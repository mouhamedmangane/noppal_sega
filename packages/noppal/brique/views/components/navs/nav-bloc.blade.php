

<ul class="list-unstyled components  pt-4">
    @foreach ($navElementModels as $navElementModel)
        @if($navElementModel->droit)
            @if ($isNavItemModel($navElementModel))
                <x-npl::navs.nav-item :name="$navElementModel->name" :url="$navElementModel->url" :icon="$navElementModel->icon" :active="$navElementModel->active" />           
            @elseif ($isNavGroupModel($navElementModel))
                <x-npl::navs.nav-group :name="$navElementModel->name" :navElementModels="$navElementModel->navElementModels" :icon="$navElementModel->icon" :active="$navElementModel->active"/>       
            @endif
        @endif
    @endforeach
</ul>
