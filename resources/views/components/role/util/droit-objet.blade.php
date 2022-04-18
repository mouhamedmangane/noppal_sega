<tr>
    <td>
        {{ $objet->nom}}
        <input type="hidden" name="objet[{{ $objet->id }}]" value="{{ $objet->id }}" >
    </td>

    <td class="bg-evidence-1" >
        <x-npl::input.checkbox name="r[]" value="{{ $objet->id }}" label="r"   checked="{{ $isCheck($roleObjet->r) }}" />
    </td>
    <td class="bg-evidence-1">
        <x-npl::input.checkbox name="c[]" value="{{ $objet->id }}" label="c" checked="{{ $isCheck($roleObjet->c) }}"/>
    </td>
    <td class="bg-evidence-1">
        <x-npl::input.checkbox name="u[]" value="{{ $objet->id }}" label="u" checked="{{ $isCheck($roleObjet->u) }}"/>
    </td>
    <td class="bg-evidence-1">
        <x-npl::input.checkbox name="d[]" value="{{ $objet->id }}" label="d" checked="{{ $isCheck($roleObjet->d) }}"/>
    </td>

    <td class="bg-evidence-2">
        <x-npl::input.checkbox name="ro[]" value="{{ $objet->id }}" label="ro" checked="{{ $isCheck($roleObjet->ro) }}"/>
    </td>
    {{-- <td class="bg-evidence-2">
        <x-npl::input.checkbox name="co[]" value="{{ $objet->id }}" label="co" checked="{{ $isCheck($roleObjet->co) }}"/>
    </td> --}}
    <td class="bg-evidence-2">
        <x-npl::input.checkbox name="uo[]" value="{{ $objet->id }}" label="uo" checked="{{ $isCheck($roleObjet->uo) }}"/>
    </td>
    <td class="bg-evidence-2">
        <x-npl::input.checkbox name="do[]" value="{{ $objet->id }}" label="do" checked="{{ $isCheck($roleObjet->do) }}"/>
    </td>

</tr>


