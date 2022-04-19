
<style>

       .l-bg-cherry {
           background: linear-gradient(to right, #493240, #f09) !important;
           color: #fff;
       }

       .l-bg-blue-dark {
           background: linear-gradient(to right, #373b44, #4286f4) !important;
           color: #fff;
       }
       .l-bg-cyan {
           background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
           color: #fff;
       }

       .l-bg-green {
           background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
           color: #fff;
       }

       .l-bg-orange {
           background: linear-gradient(to right, #f9900e, #ffba56) !important;
           color: #fff;
       }

       .l-bg-cyan {
           background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
           color: #fff;
       }
       .l-bg-green-dark {
           background: linear-gradient(to right, #0a504a, #38ef7d) !important;
           color: #fff;
       }

       .l-bg-orange-dark {
           background: linear-gradient(to right, #a86008, #ffba56) !important;
           color: #fff;
       }

       .card .card-statistic-3 .card-icon-large .fas, .card .card-statistic-3 .card-icon-large .far, .card .card-statistic-3 .card-icon-large .fab, .card .card-statistic-3 .card-icon-large .fal {
           font-size: 110px;
       }

       .card .card-statistic-3 .card-icon {
           text-align: center;
           line-height: 50px;
           margin-left: 15px;
           color: #000;
           position: absolute;
           right: 5px;
           top: 20px;
           opacity: 0.1;
       }


</style>

    <div class="card {{$couleur}}">
        <div class="card-statistic-3 p-4">
            <div class="card-icon card-icon-large"><i class="fas fa-{{$icon}}"></i></div>
            <div class="mb-4">
                <h5 class="card-title mb-0">{{$title}}</h5>
            </div>
            <div class="row align-items-center mb-2 d-flex">
                <div class="col-8">
                    <h3 class="d-flex align-items-center mb-0">
                        {{$valeur}}
                    </h3>
                </div>
                {{-- <div class="col-4 text-right">
                    <span style="font-size: 10px">ACCOMPTE</span><br>
                    <span>{{$nombre}}<i class="fa fa-arrow-up"></i></span>
                </div> --}}
            </div>
            {{-- <div class="progress mt-1 " data-height="8" style="height: 8px;">
                <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
            </div> --}}
        </div>
    </div>

