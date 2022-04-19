@if (!empty($attributes['id']))
    @props(['idd'=> $attributes['id']])
@else
    @props(['idd'=>Npl\Brique\ViewModel\GenId::newId()])
@endif

<select  id="{{ $idd }}" 
        class="n-select-link-dt {{ $attributes['class'] }} border-none  " >
    @foreach ($dt as $key=>$item )
        <option value="{{ $key }}"
                class="n-select-link-item" 
                @if ($key == $value) 
                    selected="true"
                   
                @endif>            
                {{ $item}}
        </option>
    @endforeach
</select>


@once
@push('script')
    <script>
        $(document).ready(function(){
            
            $(".n-select-link-dt").on('change',function(){
                let idDataTable = "#{{ $idDataTable }}";
                let dataTable=$(idDataTable).DataTable();
                dataTable.ajax.url($(this).val()).load();
                // alert(dataTable.ajax.url);
                // dataTable.ajax.reload();
            });
        });
    </script>
        
@endpush
@endonce<div>
    <!-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin -->
</div>