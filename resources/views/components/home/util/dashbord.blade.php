@section('ly-main-top')
<x-npl::navs-tabs.nav id="myTab" class="px-2  ">
    <x-npl::navs-tabs.item text="Général" idPane="general"  id="general-tab"  active="true" classLink="ml-3" icon="fab fa-dashcube" />
    <x-npl::navs-tabs.item text="Jour" idPane="jour"  id="jour-tab"    icon="fas fa-sun" />
    <x-npl::navs-tabs.item text="Mois" idPane="mois" id="mois-tab" icon="fas fa-moon" />
    <x-npl::navs-tabs.item text="Année" idPane="annee" id="annee-tab" icon="fas fa-calendar-alt"  />
</x-npl::navs-tabs.nav>
@endsection

<x-npl::navs-tabs.content id="myTabContent" class="px-4 py-3 " >

    <x-npl::navs-tabs.pane id="general" active="true" >

<div class="container-fluid">


    <div class="mt-1 mb-1">
        <h4>Global </h4>
        <div class="row mt-2" >
                <div class="col-md-4 col-sm-12">
                    <x-generic.dashboard.cadre2 title="Etat Caisse" :valeur="$donnees['etat_caisse']" :nombre="$donnees['nbre_accompte']" icon="money-bill-wave" couleur="l-bg-white"/>
                </div>
                <div class="col-md-4 col-sm-12">
                    <x-generic.dashboard.cadre2 title="Accompte" :valeur="$donnees['dette']" :nombre="$donnees['nbre_accompte']" icon="money-bill-wave" couleur="l-bg-orange"/>
                </div>
                <div class="col-md-4 col-sm-12">
                    <x-generic.dashboard.cadre2 title="Payé non Livré" :valeur="$donnees['paye_non_livre']" :nombre="$donnees['nbre_accompte']" icon="info" couleur="l-bg-cyan"/>
                </div>

        </div>
    </div>

    <div class="mt-4">
        <h4>Bilan Jour</h4>
        <div class="row mt-2 " >
            <div class="col-md-4 col-sm-12 mt-2">
                <x-generic.dashboard.cadre2 title="Total Vente/Jour" :valeur="$donnees['caisse_jour'].' / '.$donnees['nbre_tronc']" :nombre="$donnees['nbre_accompte']" icon="coins" couleur="l-bg-blue-dark"/>
            </div>
            <div class="col-md-4 col-sm-12 mt-2">
                <x-generic.dashboard.cadre2 title="Total Encaisse/Jour" :valeur="$donnees['total_encaisse']" :nombre="$donnees['nbre_accompte']" icon="coins" couleur="l-bg-green"/>
            </div>
            <div class="col-md-4 col-sm-12 mt-2">
                <x-generic.dashboard.cadre2 title="Dépense /jour" :valeur="$donnees['depense_jour']" :nombre="$donnees['nbre_tronc']" icon="truck-loading" couleur="l-bg-orange"/>
            </div>

        </div>
    </div>

    <div class="mt-4">
        <h4>Bilan Mois</h4>
        <div class="row mt-2">
            <div class="col-md-4 col-sm-12 mt-2">
                <x-generic.dashboard.cadre2 title="Total Vente/Mois" :valeur="$donnees['caisse_mois']" :nombre="$donnees['nbre_accompte']" icon="coins" couleur="l-bg-green-dark"/>
            </div>
            <div class="col-md-4 col-sm-12 mt-2">
                <x-generic.dashboard.cadre2 title="Troncs Vendus/Mois" :valeur="$donnees['nbre_tronc_mois']" :nombre="$donnees['nbre_tronc']" icon="truck-loading" couleur="l-bg-blue-dark"/>
            </div>
            <div class="col-md-4 col-sm-12 mt-2">
                <x-generic.dashboard.cadre2 title="Total Dépense/Mois" :valeur="$donnees['depense_mois']" :nombre="$donnees['nbre_tronc']" icon="truck-loading" couleur="l-bg-cherry"/>
            </div>
        </div>

    </div>









    <div class="mt-4">
        <h4>Bilan Annuel</h4>
        <div class="row mt-2">
            <div class="col-md-4 col-sm-12 mt-2">
                <x-generic.dashboard.cadre2 title="Total Vente/Année" :valeur="$donnees['vente_annee']" :nombre="$donnees['nbre_accompte']" icon="coins" couleur="l-bg-green-dark"/>
            </div>
            <div class="col-md-4 col-sm-12 mt-2">
                <x-generic.dashboard.cadre2 title="Total Dépense/Année" :valeur="$donnees['depense_annee']" :nombre="$donnees['nbre_tronc']" icon="truck-loading" couleur="l-bg-cherry"/>
            </div>
        </div>

    </div>

    <div class="mt-4">
        <h3 class="text-align-center pt-5">Evolution des Ventes</h3>
        <div class="pb-4 pt-2">
            <div class="row my-5">
                <div class="col-md-12  d-flex justify-content-center ">
                    <div class="chart-900 chart-sm" style="">
                        <x-npl::charts.chart type="line" id="myChart" xAxisKey="jour" yAxisKey="montant"
                                            :labels="$list_jour" :datas="$evolutionVente" />

                    </div>
                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="row ">
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="chart-500 chart-sm" >
                        <canvas id="myPolar"  ></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="row ">
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="chart-900 chart-sm" >
                        <canvas id="myLineAnnee"  ></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>







</div>

    </x-npl::navs-tabs.pane>

    <x-npl::navs-tabs.pane id="jour" active="true" >
        <div>
            <h1 class="bg-success text-white rounded p-2 ">
                Encaissement:
                {{$donnees['total_encaisse']}} FCFA
            </h1>
            <div class="w-100">
                <x-npl::data-table.simple
                    name="myDataTableEncaissement"
                    class="table-text-lg  "
                    dom="t"
                    scrollY='100%'
                    url="{{ url('home/encaissement/'.$date->format('Y-m-d')) }}"
                    :columns="[
                        (object)['name'=>'Nom','propertyName'=>'nom','classStyle'=>''],
                        (object)['name'=>'Montant','propertyName'=>'somme_f','classStyle'=>''],
                    ]"/>
            </div>
        </div>

        <div class="mt-2">
            <h1 class="bg-danger text-white rounded p-2 " style="">
                Depenses:

                {{$donnees['depense_jour']}} FCFA
            </h1>
            <p>
                <x-npl::data-table.simple
                    name="myDataTableDepense"
                    class="table-text-lg "
                    dom="t"
                    scrollY='100%'
                    url="{{ url('home/depense/'.$date->format('Y-m-d')) }}"
                    :columns="[
                        (object)['name'=>'Desc','propertyName'=>'description_f','classStyle'=>''],
                        (object)['name'=>'Montant','propertyName'=>'somme_f','classStyle'=>''],
                    ]"/>
            </p>
        </div>

        <div>
            <h1 class="bg-primary text-white rounded p-2 ">
                Paye Non Livre Encaissé :
                {{$donnees['paye_non_livre_jour']}} FCFA
            </h1>
        </div>
    </x-npl::navs-tabs.pane>

    <x-npl::navs-tabs.pane id="mois" active="true" >

    </x-npl::navs-tabs.pane>

    <x-npl::navs-tabs.pane id="annee" active="true" >

    </x-npl::navs-tabs.pane>

</x-npl::navs-tabs.content>
@push('script')
<script src="{{asset('plugin/chartjs/dist/chart.min.js?v=1')}}"></script>
<script>
    $(function(){

        $('.ly-toolbar').css('height','0px');
        $('.ly-toolbar').css('min-height','0px');
        $('.ly-toolbar').css('max-height','0px');




//
var ctx1 = document.getElementById('myPolar');
var myChart1= new Chart(ctx1, {
    type: 'polarArea',
    data: {
        labels: @json($TroncMieuxVendu_titre()),
        datasets: [{
            label: 'Evolution des vente au cour du mois',
            data: @json($TroncMieuxVenduData()),
            backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(75, 192, 192)',
            'rgb(255, 205, 86)',
            'rgb(201, 203, 207)',
            'rgb(54, 162, 235)'
            ],
        }]
    }
});

//
var ctx = document.getElementById('myLineAnnee');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($list_mois),
        datasets: [{
            label: 'Evolution des vente au cour du l annee',
            data: @json($evolutionVenteAnneeData),
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            },

        },
        parsing: {
                xAxisKey: 'mois',
                yAxisKey: 'montant'
            }
    }
});




});
</script>

@endpush
