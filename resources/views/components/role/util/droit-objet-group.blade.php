<table class="table table-light">
    <thead>
        <tr>
            <th rowspan="2">Nom Fonction</th>
            <th colspan="4" class="bg-evidence-1">Droit Sur les Object du l'initiateur</th>
            <th colspan="4" class="bg-evidence-2">Droit Sur les Object des Autres</th>
        </tr>
        <tr>
            <th class="bg-evidence-1">Lire</th>
            <th class="bg-evidence-1">Creer</th>
            <th class="bg-evidence-1">Modifier</th>
            <th class="bg-evidence-1">Supprimer</th>

            <th class="bg-evidence-2">Lire</th>
            {{-- <th class="bg-evidence-2">Creer</th> --}}
            <th class="bg-evidence-2">Modifier</th>
            <th class="bg-evidence-2">Supprimer</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($objets as $objet )
            <x-role.util.droit-objet :objet="$objet"  :roleObjet="$getRoleObjectByObjet($objet)"  />
        @endforeach

    </tbody>
</table>

