@isset ($attributes['required'])
        @props(['req'=> $attributes['required']])
@else
        @props(['req'=> 'false'])
@endif

<x-npl::forms.form-table-line class="{{ $attributes['class'] }}" :idMessage="$name">

    <x-slot name="label">
        <x-npl::forms.form-table-label  :labelText="$labelText" required="{{ $req }}" />
    </x-slot>
    
    <x-npl::input.checkbox :name="$name" 
                          labelText=""
                          :value="$value"
                          id="{{ $attributes['id'] }}" 
                          required="{{ $req }}"
                          checked="{{ $attributes['checked'] }}"
                          placeholder="{{ $attributes['placeholder'] }}"
                          :prev="$attributes['prev']"
                          :next="$attributes['next']"
                           />
    
</x-npl::forms.form-table-line>