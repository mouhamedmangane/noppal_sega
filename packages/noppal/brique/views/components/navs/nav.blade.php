<nav id="nav-v">

    @foreach ($navModel->navBlocModels as $navBlocModel)
        @if($navBlocModel->droit)
            <x-npl::navs.nav-bloc :name="$navBlocModel->name" :navElementModels="$navBlocModel->navElementModels"  />           
        @endif
    @endforeach

</nav>