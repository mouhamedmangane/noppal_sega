<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        @yield('header')
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugin/font/css/all.min.css?family=Nunitdssdfo:wght@400;600;700&display=swap') }}">
        <link rel="stylesheet" type="text/css"  href="{{ URL::asset('dist/css/materialize.css?v=1') }}">


        <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugin/bootstrap441/css/bootstrap.min.css?v=1') }}">

        @stack('header')

        <link rel="stylesheet" type="text/css" href="{{ URL::asset('dist/css/components.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('dist/css/style.css?v=1') }}">
        {{-- <link rel="stylesheet" href="{{ URL::asset('css/table-fixed.css') }}"> --}}

        <style>

            body {
                font-family: "Segoe UI", "Segoe UI Web (West European)", "Segoe UI", -apple-system, BlinkMacSystemFont, Roboto, "Helvetica Neue", sans-serif;
            }



        </style>

        @stack("styleBody")
    </head>

    <body style=" ">

        <div id="load" class="d-flex justify-content-center flex-wrap align-items-center "
            style="position: fixed;top:0px;left:0px;width:100%;height:100vh;background:#3F51B5;z-index:9999;" >
            <div class="w-100 text-center">
                <h1 class="text-white">Noppal Inventory</h1>
                <div class="mt-5" style="height: 18px;">
                    <div class="boule active"></div>
                    <div class="boule ml-3"></div>
                    <div class="boule ml-3"></div>
                    <div class="boule ml-3"></div>
                </div>
            </div>

        </div>

        <script>
            function chargement(){
                let boules= document.querySelectorAll('.boule');
                for (let i = 0; i < boules.length; i++) {
                    console.log(boules[i].classList);
                    if(boules[i].classList.contains("active")){
                        boules[i].classList.remove("active");
                        if(i==boules.length-1)
                            boules[0].classList.add("active");
                        else
                            boules[i+1].classList.add("active");
                        break;
                    }

                }
            }
            setInterval(() => {
                            chargement();

            }, 600);
        </script>

        @yield('head-body')

        <div class="r-bar"></div>

        <div class="wrapper">
            @yield('sidebar')
            <div id="content" class="position-relative" style="flex-grow: 1;">
                @yield('content')
            </div>
        </div>

        @stack('modal')
      <script>

            window.onload=function() {
			    document.querySelector('#load').style.display="none";
                document.querySelector('#load').remove();
            }
	    </script>


        <script src="{{ URL::asset('dist/js/jquery.js?v=1') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('dist/js/popper.js?v=1') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('plugin/bootstrap441/js/bootstrap.bundle.js?v=1') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('dist/js/components.js') }}" type="text/javascript"></script>
        {{-- <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/chart-area-demo.js"></script>
        <script src="js/demo/chart-pie-demo.js"></script> --}}

        @stack('script0')

        @stack('script')

        @stack('script2')

    </body>
</html>
