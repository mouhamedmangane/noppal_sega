
<div style="width: 700px;">
    <h1 class="border-3" style="border-style: dashed;">DOUBLON</h1>
    <div>
        <div class="d-flex">
            <h6 class="text-center">MB MultiBusiness</h6>
            <h6 class="text-center mb-1 pb-1">SCIERIE RIO FRESCO</h6>
        </div>

        <p class="" >
            <span class="text-align-center">
               Gouye Aldiana, RUFISQUE Tel: 33 871 21 02 / 77 293 59 52
            </span>
        </p>
    </div>


    <div class="d-flex justify-content-between my-4">
        <div class="">
            <div>
                <span>N° Vente : </span>
                <span>VS-{{$vente->id}}</span>
            </div>
            <div>
                <span>Date Vente : </span>
                <span>{{$vente->created_at->format('d-m-Y')}}</span>
            </div>
        </div>
        <div>
            <div class="text-right">
                <span>Client : </span>
                <span>
                    @if($vente->client)
                        {{$vente->client->nameAndPhone()}}
                    @else
                        {{$vente->nom.' / '.$vente->telephone}}
                    @endif
                </span>
            </div>
            <div class="text-right">
                <span>Date Vente : </span>
                <span>{{$vente->created_at->format('d-m-Y')}}</span>
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Quantite</th>
                <th>Designation</th>
                <th class="text-center">Prix Unitaire</th>
                <th class="text-center">Prix Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($vente->ligne_ventes as $ligne_vente)
                @if($ligne_vente->bois_produit->discriminant==\App\ModelHaut\Tronc::DISCRIMINANT)
                <tr>
                    <td>
                        <span>{{ $ligne_vente->quantite }}</span>
                    </td>
                    <td>
                        <span> {{$ligne_vente->identifiant}} </span>
                        <span>
                            {{number_format($ligne_vente->bois_produit->poids,2,',',' ')}} kg
                        </span>
                    </td>
                    <td class="text-right">
                        {{ $ligne_vente->prix_total / $ligne_vente->bois_produit->poids }}
                    </td>
                    <td class="text-right">
                        {{ $ligne_vente->prix_total }} FCFA
                    </td>
                </tr>
                @elseif ($ligne_vente->bois_produit->discriminant==\App\ModelHaut\Planche::DISCRIMINANT)
                <tr>
                    <td>
                        <span>{{ $ligne_vente->quantite }}</span>
                    </td>
                    <td >
                        <span> {{$ligne_vente->identifiant}} </span>
                        <span>
                            {{number_format($lv->bois_produit->poids,2,',',' ')}} kg
                        </span>
                    </td>
                    <td class="text-right">
                        {{ $ligne_vente->prix_total / $ligne_vente->bois_produit->poids }}
                    </td>
                    <td class="text-right">
                        {{ $ligne_vente->prix_total }} FCFA
                    </td>
                </tr>
                @endif

            @endforeach

            <tfoot>
                <tr>
                    <th colspan="2">
                        Total Poids Toncs :
                        <span>
                            {{number_format($vente->sumKg(),0,'',' ')}}
                             kg
                        </span>
                     </th>
                    <th colspan='2'class="text-right">
                            <span>Montant Total : </span>
                            <span>{{number_format($vente->sumVente(),0,'',' ')}} FCFA</span>
                    </th>
                </tr>
            </tfoot>

        </tbody>
    </table>

    <div class="d-flex justify-content-end mt-4">
        <div class="mr-3"><u>Caisse:</u></div>
    </div>
</div>

