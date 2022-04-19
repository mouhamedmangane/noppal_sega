@isset ($attributes['required'])
        @props(['req'=> $attributes['required']])
@else
        @props(['req'=> 'false'])
@endif
<x-npl::forms.form-table-line class="{{ $attributes['class'] }}">

    <x-slot name="label">
        <x-npl::forms.form-table-label  :labelText="$labelText" :required="$req" />
    </x-slot>
    <x-npl::input.interval-input id="{{ $attributes['id'] }}"
                                    :type="$type"
                                    :name="$name"
                                    required="{{ $req }}"
                                    :minValue="$minValue"
                                    :maxValue="$maxValue"/>


</x-npl::forms.form-table-line>
