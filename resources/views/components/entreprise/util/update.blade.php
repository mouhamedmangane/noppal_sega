<form action="{{ url('param-compte/entreprise') }}" method="post"
    id="update_entreprise_form" enctype="multipart/form-data">
    @csrf
    <div class="mx-3">
        <div class="row">
            <div class="col-lg-6 col-md-5 col-sm-12">
                <x-npl::forms.form-table >

                    <x-npl::forms.form-table-text name="nom" labelText="Nom Role" class="" :value="$entreprise->nom"
                            required="true" placeholder="Nom role" id="nom_role"/>
                    <x-npl::forms.form-table-text name="tel_1" labelText="Telephone 1" class="" :value="$entreprise->tel_1"
                            placeholder="telephone" id="tel1"/>
                    <x-npl::forms.form-table-text name="tel_2" labelText="Telephone 2" class="" :value="$entreprise->tel_2"
                            placeholder="telephone" id="tel2"/>
                    <x-npl::forms.form-table-text name="ninea" labelText="NINEA" class="" :value="$entreprise->ninea"
                                placeholder="ninea" id="ninea"/>

                    <x-npl::forms.form-table-line class=" rounded rounded-circle ">
                        <x-slot name="label">
                            <x-npl::forms.form-table-label  labelText="Logo" :required="false" />
                        </x-slot>
                        <x-npl::input.photo id="logo" name="logo" :url="(!empty($entreprise->logo))?asset('images/'.$entreprise->logo):''" x="130" y="130" classImage=" rounded-circle"/>
                    </x-npl::forms.form-table-line>

                </x-npl::forms.form-table>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12">
                <x-npl::forms.form-table >

                </x-npl::forms.form-table>
            </div>

        </div>
    </div>



</form>
