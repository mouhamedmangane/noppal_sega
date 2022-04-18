

<div class="row mb-2">
    <div class=" col-md-12 col-sm-12" style="min-width: 300px;">

        <ul class="list-group">
            <li class="list-group-item">
                <div class="col-md-3 col-lg-3">Créé le : </div>
                <div class="ml-5">{{ $created_at_f }}</div>
            </li>
            <li class="list-group-item">
                <div class="col-md-3 col-lg-3">Modifée le : </div>
                <div class="ml-5">{{ $update_at_f }}</div>
            </li>

            @if($user)
            <li class="list-group-item">
                <div class="col-md-5 col-lg-5">Derniére Modification Par : </div>
                <div class="ml-5">
                    <x-npl::links.simple :src="asset('images/users/'.$user->photo)"
                                         :url="url('param-compte/users/'.$user->id)"
                                         :text="$user->name"
                                         class="lien-sp" />
                </div>
            </li>
            @endif

        </ul>
    </div>
</div>
