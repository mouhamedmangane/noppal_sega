@if($attributes['required'])
        @props(['req'=> $attributes['required']])
@else
        @props(['req'=> 'false'])
@endif

<x-npl::forms.form-table-line class="{{ $attributes['class'] }}" disposition="{{ $attributes['disposition'] }}" :idMessage="'form__message__'.$name">

    <x-slot name="label">
        <x-npl::forms.form-table-label  :labelText="$labelText" required="{{ $req }}"  disposition="{{ $attributes['disposition'] }}" />
    </x-slot>

    <x-npl::input.telephone :name="$name"
                               :indicatif="$indicatif"
                               :numero="$numero"
                               :idTelephone="$idTelephone"
                               id="{{ $attributes['id'] }}"
                               required="{{ $req }}"
                               placeholder="{{ $attributes['placeholder'] }}" />

</x-npl::forms.form-table-line>
