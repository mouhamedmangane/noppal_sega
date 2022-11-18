@if (!empty($attributes['id']))
    @props(['idd'=> $attributes['id']])
@else
    @props(['idd'=>Npl\Brique\ViewModel\GenId::newId()])
@endif

<div class="d-flex align-items-center">
    @if($idTelephone>0)
        <input type="hidden" name="{{$name.'[id]'}}" value="{{$idTelephone}}">
    @endif
    <x-npl::input.text  :name="$name.'[indicatif]'" id="$idd.'__indicatif'" class="indicatif number-input" :value="$indicatif" placeholder="+221" type="tel" />
    <x-npl::input.text  :name="$name.'[numero]'" id="$idd.'__numero'" class="ml-2 number-input" :value="$numero" placeholder="XX XXX XX XX" />
</div>
@once
@push('script')
<script type="text/javascript">
    $(function(){
        $('.number-input').on('keyup',function(e){
            let valeur=$(this).val()+'';
            $(this).val(valeur.replace(/\D+/,''));
        });
    });
</script>
@endpush
@endonce
