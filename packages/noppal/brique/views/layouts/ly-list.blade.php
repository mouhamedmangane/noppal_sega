@section('content')


    <div class="ly-toolbar">
        @yield('ly-toolbar')
    </div>

    <div class="ly-content ly-list-content">
        <div class="ly-alert">
            @yield('ly-alert')
       </div>
        <div class="ly-title">
             @yield('ly-title')
        </div>
        <div class="ly-main" id="my-main">
            <div class="ly-main-content" >
                @yield('ly-main-content')
            </div>
            <div class="ly-main-bot">
                @yield('ly-main-bot')
            </div>
        </div>
    </div>

@endsection

