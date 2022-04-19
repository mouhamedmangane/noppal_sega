<div class="dropdown ddw-cacha" id="{{ $id }}" >
    <button class="btn btn-sm d-flex align-items-center  mr-3 dropdown-toggle" type="button"  data-toggle="dropdown">
        <i class="material-icons-outlined " style="font-size:16px;">{{ $attributes['icon'] }}</i>
        <span class="ml-1"> {{ $label }}</span>    
    </button>
    <div class="dropdown-menu ct-cacha " style="width: 180px;" >
      
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