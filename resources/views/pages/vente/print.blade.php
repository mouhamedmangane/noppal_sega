@extends('layouts.print-sm')
@section('head')
 <title>Vente VS-{{$vente->id}}</title>
 <style>
     @media print {
        *{
            font-size: 80px;
        }
        body{
            width:100%;
            height: 100%;
        }
        .ticket{
            width: 100%;
        }
        body{
            width: 100%;

        }
        table{
            width: 100%;

        }
        .text-sm{
            font-size: 70px;
        }


    }
 </style>
@endsection

@section('body')
<div class="ticket">

    <p class="" >
        <span class="text-align-center">
            SCIERIE RIO FRESCO /Gouye Aldiana, RUFISQUE
        </span>
    </p>


    <p>
        <span>
            @if($vente->client)
                {{$vente->client->nameAndphone()}}
            @else
                {{ $vente->nom}}/{{ $vente->telephone}}
            @endif
        </span>
    </p>

    <h6>
        <span class="">TICKET :</span>
        <span class="">
            <strong>
                <u>{{$vente->numero()}} </u>
            </strong>
        </span>
    </h6>
    @if($vente->etat!= \App\ModelHaut\VenteHaut::COMPLETE)
        <p>
           Montant Versé : {{ $vente->sumPayement() }} fcfa
        </p>
    @endif

    <table class="my-1">

        <tbody>
            @foreach ($vente->ligne_ventes as $lv )
            <tr class="my-1">
                <td class="description my-1"> {{$lv->bois_produit->bois->name}}
                     ->{{$lv->bois_produit->identifiant}}

                     @if($lv->bois_produit->discriminant==\App\ModelHaut\Tronc::DISCRIMINANT)
                     ->{{number_format($lv->bois_produit->poids,2,',',' ')}} kg/
                     {{ $lv->prix_total / $lv->bois_produit->poids}}
                     @else
                     ->{{number_format($lv->bois_produit->m3,2,',',' ')}} m<sup>3</sup>/
                     {{ $lv->prix_total / $lv->bois_produit->m3}}
                     @endif
                     ->{{$lv->prix_total}} fcfa</td>
            </tr>
            @endforeach


        </tbody>

    </table>

    <p class="mt-2">
        Prix TOTAL: {{number_format($vente->sumVente(),0,'',' ')}} fcfa
    </p>

    @if($vente->etat!=\App\ModelHaut\VenteHaut::COMPLETE)
        <p>
            Difference : {{ $vente->sumRestant() }} fcfa
        </p>
        <p>
           Note : {{ $vente->note }}
        </p>
    @endif

    <p class="mt-2">
        <span class="text-sm">Tel: 33 871 21 02 / 77 293 59 52</span>
    </p>

</div>


@endsection
