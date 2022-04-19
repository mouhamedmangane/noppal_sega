
<tr class="n-form-table-row ">

    <td style="white-space: nowrap;min-width:150px;@if($attributes['disposition']=='block')display:block; padding-bottom: 5px!important;@endif" 
        class=" n-form-table-col-label pl-3 py-3 ">
        {{ $label }} 
    </td>

    <td style="width: 100%;@if($attributes['disposition']=='block')display:block;@endif" class="mr-2 n-form-table-col-input n__parent__message " >
        {{ $slot }}
        <div class="form-table-feedback n__element__message" id="{{ $attributes['idMessage'] }}">
            
        </div>
    </td>
</tr>