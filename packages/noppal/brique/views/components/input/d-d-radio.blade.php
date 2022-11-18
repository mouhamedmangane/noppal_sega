<div class="dropdown ddw-cacha" id="{{ $id }}" >
    <button class="btn-tb-down btn-radio btn btn-sm d-flex align-items-center  mr-3" type="button"  data-toggle="dropdown">
        <i class="material-icons-outlined " style="font-size:16px;">{{ $attributes['icon'] }}</i>
        <span class="ml-1"> {{ $label }}</span>    
    </button>
    <div class="rounded border py-2 px-1 ct-cacha bg-white facile cacher " style="width: 180px;position:fixed;z-index:9999;" >
      
        <x-npl::input.radios 
                                :defaultSelected="$attributes['defaultSelected']"
                                id="$id"
                                :dt="$dt" :name="$name"  
                                class="dropdown-item  pr-1 " 
                                :dataSave="$attributes['dataSave']"
                                :classRadio="''.$attributes['classRadio']"
                                :classLabel="'ml-2 w-100 '.$attributes['classLabel']" />
    </div>
</div>