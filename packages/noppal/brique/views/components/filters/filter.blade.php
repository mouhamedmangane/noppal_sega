<div class=" dropdown ddw-cacha" >
    <button class="btn-tb-down btn-filter btn btn-sm d-flex align-items-center  mr-3 " type="button">
        <i class="material-icons-outlined " style="font-size:16px;">filter_alt</i>
        <span class="ml-1"> Filtrer</span>    
    </button>
    <div class="rounded border py-2 px-1 ct-cacha bg-white facile cacher  " style="width: 240px;position:fixed;z-index:9999;" >
        @foreach ($filter->rows() as $ligne )
            <x-dynamic-component :component="$ligne->getComponentName()" :ligne="$ligne"  />
            @if (!$loop->last)
                <div class="dropdown-divider"></div>
            @endif
        @endforeach 
        {{ $slot }}
    </div>
</div>

@once
@push('script')
    <script>
  
    </script>    
@endpush
@endonce

@once
    @push('script')
     <script>
         $(function(){
            $('.ligne-filter-select').unbind();
            $('.ligne-filter-select').on('click',function(e){
                e.stopPropagation();
               let input = $(this).find(".ligne-filter-select-input").first();
               let newValeur =  input.prop('checked');
               input.prop('checked',newValeur);
               
            })
         });
     </script>   
    @endpush
@endonce