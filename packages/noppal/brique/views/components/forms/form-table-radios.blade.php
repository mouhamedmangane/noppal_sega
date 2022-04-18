@isset ($attributes['required'])
        @props(['req'=> $attributes['required']])
@else
        @props(['req'=> 'false'])
@endif

<x-npl::forms.form-table-line class="{{ $attributes['class'] }}">

    <x-slot name="label">
        <x-npl::forms.form-table-label  :labelText="$labelText" :required="$req" />
    </x-slot>

    <x-npl::input.radios :name="$name" 
                            :dt="$dt"
                            :value="$value"
                            id="{{ $attributes['id'] }}" 
                            required="{{ $req }}"
                            type="{{ $attributes['type'] }}"
                            />
</x-npl::forms.form-table-line>