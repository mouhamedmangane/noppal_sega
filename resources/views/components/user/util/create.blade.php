@if(isset($user->id))
   @props([
        'url_form'=>url("param-compte/users/".$user->id),
        'method_form'=>'post'
   ])
@else
    @props([
        'url_form'=>url("param-compte/users/"),
        'method_form'=>'post'
    ])
@endif



@section('ly-main-top')
<x-npl::navs-tabs.nav id="myTab" class="px-2  ">
    <x-npl::navs-tabs.item text="Information Générale" idPane="general"  id="general-tab"  active="true" classLink="ml-3" />
    <x-npl::navs-tabs.item text="Details" idPane="details" id="details-tab"  />
</x-npl::navs-tabs.nav>
@endsection

<form action="{{ $url_form}}" method="post" id="create_user_form" enctype="multipart/form-data">
    @if(isset($user->id))
        @method('PUT')
    @endif
    @csrf
    <input type="hidden" value="{{  (isset($user->id)) ? $user->id :''}}">
    <x-npl::navs-tabs.content id="myTabContent" class="px-4 py-3" >
        {{-- div general --}}
        <x-npl::navs-tabs.pane id="general" active="true" >
            <div class="row">

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <x-npl::forms.form-table-line class=" rounded rounded-circle ">
                        <x-slot name="label">
                            <x-npl::forms.form-table-label  labelText="Photo Profil" :required="false" />
                        </x-slot>
                        <x-npl::input.photo id="photo" name="photo" :url="(!empty($user->photo))?asset('images/users/'.$user->photo):''" x="130" y="130" classImage=" rounded-circle"/>
                     </x-npl::forms.form-table-line>

                     <x-npl::forms.form-table>

                        <x-npl::forms.form-table-text name="tel" labelText="Telephone"  :value="$user->tel"
                                  placeholder="Donner le Telephone" id="telephone" />

                        <x-npl::forms.form-table-text name="ncni" labelText="NCNI" :value="$user->ncni"
                                  placeholder="N° Carte di'dentité" id="nom"  />
                    </x-npl::forms.form-table>

                </div>

                <div class="col-lg-7 col-md-6 col-sm-12">
                    <x-npl::forms.form-table >


                        <x-npl::forms.form-table-text name="nom" labelText="Nom"  :value="$user->name"
                              required="true"    placeholder="Donner le Nom" id="nom" />

                        <x-npl::forms.form-table-select name="role_id" labelText="Role" id='role_id' :dt="$roles" :value="$user->role_id"  required="true" />


                        <x-npl::forms.form-table-text name="login" labelText="login" :value="$user->email"
                                required="true" placeholder="Donner le login" id="login"/>


                        <x-npl::forms.form-table-text name="pwd" labelText="Mot de passe"
                                required="true"  placeholder="Creer un mot de passe" id="password" typpe="password" />

                        <x-npl::forms.form-table-text name="pwd_confirmation" labelText="Confirmer mot de passe"
                                 required="true"  placeholder="Confirmer le mot de passe" id="password-confirm" typpe="password"/>


                    </x-npl::forms.form-table>
                </div>




            </div>
        </x-npl::navs-tabs.pane>
        {{-- droit --}}
        <x-npl::navs-tabs.pane id="details"  >
            @if($user->id)
            <x-util.detail :model="$user" />
            @endif
        </x-npl::navs-tabs.pane>


    </x-npl::navs-tabs.content>

</form>
