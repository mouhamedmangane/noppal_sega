{{-- selectDataName le name recuperer au niveau du data pour les case a coché --}}
@if (!$attributes['selectDataName'])
    @props(['selectDataName'=> 'id'])
@else
    @props(['selectDataName'=> $attributes['selectDataName']])
@endif

@props(['idSelectAll'=>($name.'selectAll')])







@if ($attributes['selectName'])
    @props(['init'=> 1 ])
@else
    @props(['init'=> 0])
@endif


<div class="w-100" style="overflow-x: auto;">
    <div class="position-relative" id="{{ $name }}__content">
    <table class="dataTable-simple  table table-borderless  table-hover  mb-0 {{ $attributes['class'] }}" id="{{ $name }}" style="{{ $attributes['style'] }}">
        <thead class="dataTable-simple-head  py-2 ">
            {{-- si selectionnable --}}
            @if ($attributes["selectName"])
                <th >
                    <input type="checkbox" class="dataTable-simple-selectAll" id="{{ $idSelectAll }}" data-var-table="{{ $name }}">
                </th>
            @endif
            {{-- les autres titres --}}
            @foreach ($columns as $column)
                <th class="@if ($loop->last) dataTable-simple-th-end  @endif @isset($column->classStyleHead) {{ $column->classStyleHead }} @endisset">
                    {{ $column->name }}
                    @if (isset($column->badge))
                        <span class="bagde {{ $column->badge->styleClass }}"> {{ $column->badge->value }}</span>
                    @endif

                </th>
            @endforeach
            <th>numero</th>
        </thead>
        <tbody class="dataTable-simple-body" id="{{ $name }}__tbody">

        </tbody>
        <tfoot class="dataTable-simple-foot">
            @foreach ($columns as $column)
                <td></td>
            @endforeach
        </tfoot>
    </table>


    <div class="dropdown position-absolute reduce-col" style="right: 3px;top:10px;">
        <a data-toggle="dropdown" href="#">
            <i class="material-icons">more_vert</i>
        </a>
        <div class="dropdown-menu">
            @foreach ($columns as $key => $column )
                @props(['idd'=>Npl\Brique\ViewModel\GenId::newId()])
                <span href="#" class="dropdown-item">
                    <input type="checkbox"
                            id="{{ $idd }}"
                            data-key ="@if($attributes['selectName']){{ $key+1 }}@else {{ $key }}@endif"
                            data-var-table="{{ $name }}"
                            value="{{ $key }}"
                           class="dataTable-simple-visible-check"
                           @if (isset($column->visible) && !$column->visible)

                           @else
                           checked="true"
                           @endif>
                    <label for="{{ $idd }}">
                      {{ $column->name }}
                    </label>
                </span>
            @endforeach

        </div>
    </div>
</div>

</div>


<x-npl::modal.optional-confirm />
<x-npl::modal.optional-alert />

{{-- push datatable src --}}
@once
    @push('script')
        <script src="{{ URL::asset('plugin/DataTables/datatables.min.js?v=1') }}"></script>
        <script src="{{ URL::asset("plugin\DataTables\RowGroup-1.1.2\js\dataTables.rowGroup.min.js?v=1") }}"></script>
        <script>
            $(function(){
                $('.dataTable-simple-visible-check').on('change',function(){
                    $("#"+$(this).data('var-table')).DataTable().column($(this).data('key')).visible($(this).prop('checked'));
                });
                $('.dataTable-simple-selectAll').on('change',function(e){

                    let checked= $(this).prop('checked');
                    table = $("#"+$(this).data('var-table')).DataTable();
                    table.rows({ page: 'current' }).nodes().to$().find(".dataTable-simple-selectItem").each(function(){
                        $(this).prop("checked",checked);
                        $(this).trigger('change');
                    });
                    //
                })
            })
        </script>
    @endpush
@endonce

{{-- push my datatable --}}
@push('script')
<script>
    $(function(){


        let selectNameSelector= '#'+'{{ $name }} .dataTable-simple-selectItem';
        // Pour RowGroup
        @if($attributes['groupByEnable'])
            var collapsedGroups = {};//  enregistre les group masquer
            let defaultCollapse=true; // designe si les group sont masquer les du premier affichage
            var checkedGroups = {}; // enregistre les groups qui son coché
        @endif

        // Noms des colonnes
        let names=@json($nameColumns());
        @if($attributes['selectName']) names.unshift('select'); @endif

        //if selectname

        function dataDefinitif( data ) {
                @if($attributes['groupBy'])collapsedGroups = {}; checkedGroups = {};@endif
                $('#{{ $name }} .dataTable-simple-selectAll').prop('checked',false);
                @if($attributes['selectName'])
                for ( var i=0, ien=data.length ; i<ien ; i++ ) {
                    data[i].select = '<input type="checkbox" name="{{ $attributes['selectName'] }}[]" class="dataTable-simple-selectItem @if($attributes['groupBy']) decaler-a-droit-1 @endif" value="'+data[i].{{ $selectDataName }}+'"  >';
                }
                @endif
                $.rmchargement();
                for ( var i=0, ien=data.length ; i<ien ; i++ ) {
                    data[i].numeroLigne = i+1;
                }

                return data;
             }



        //le datatable
        let {{ $name }} = $('#{{ $name }}').DataTable({
            @if($attributes['scrollY'])
                scrollResize: true,
                scrollY: "{{ $attributes['scrollY'] }}",
                scrollCollapse: true,
            @endif
          //le dom
          "dom": @if($attributes['dom']) '{{ $attributes['dom'] }}' @else 'tip' @endif,
          @if($attributes['pageLength'])
            "pageLength": {{ $attributes['pageLength'] }},
          @else
            "pageLength": 20,
          @endif
          
          //paggingType
          @if ($attributes['pagingType'])
              "pagingType":"{{ $attributes['pagingType'] }}",
          @endif

          //ajax
          @if($url)
          "ajax":{
             "url":"{{ $url }}",
             @if($searchId && !empty($searchId))
                "data": function(d){
                    console.log($('#{{ $searchId }}__form_search').serializeObject());
                    return $('#{{ $searchId }}__form_search').serializeObject();
                },
             @endif
             "dataSrc": function ( json ) {
                @if($attributes['groupBy'])collapsedGroups = {}; checkedGroups = {};@endif
                $('#{{ $name }} .dataTable-simple-selectAll').prop('checked',false);
                //if selectName
                @if($attributes['selectName'])
                for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
                    json.data[i].select = '<input type="checkbox" name="{{ $attributes['selectName'] }}[]" class="dataTable-simple-selectItem @if($attributes['groupBy']) decaler-a-droit-1 @endif" value="'+json.data[i].{{ $selectDataName }}+'"  >';
                }
                @endif

                // numero_ligne
                for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
                    json.data[i].numeroLigne = i+1;
                }
                console.log(json.data)
                //if idAlert
                @if($attributes['idAlert'])
                if(json.message.length>0){
                    if(json.status){
                        $.fn.nplAlertBarShow("#{{$attributes['idAlert']}}",json.message,'alert alert-success','alert-danger',1);
                    }
                    else{
                        $.fn.nplAlertBarShow("#{{$attributes['idAlert']}}",json.message,'alert alert-danger','alert-success');
                    }
                }
                else{
                    $("#{{$attributes['idAlert']}}").alert('close');
                }
                @endif
                @if($attributes['afterLoadFunction'])
                    $.AfterLoadDataTable.{{$attributes['afterLoadFunction']}}(json);
                @endif
                $.rmchargement();
                return json.data;
             },
             "error": function(error){
                $.rmchargement();
             }
             @if($attributes['idForm'])
                 "data":$('#{{ $attributes['idForm'] }}').serialize(),
                 "type":$('#{{ $attributes['idForm'] }}').attr('method'),
             @endif
          } ,
          @else
            'data':dataDefinitif(@json($dataa)),
          @endif

          //columns
          "columns":[
            @if($attributes['selectName'])
                { data:"select",name:"select",orderable:false} ,
            @endif
            @foreach($columns as $column)
                { data:"{{ $column->propertyName }}",name: "{{ $column->propertyName }}"},
            @endforeach
            {data:'numeroLigne',name:"numeroLigne",orderFixed:true},

                


          ],

          //scolumnDef
          "columnDefs": [
                @isset($attributes['selectName'] )
                    {
                        'targets':[0],
                        'className':'valign-center  dt-select-col'
                    },
                @endisset
                @foreach($columns as $key => $column)
                   {
                       "targets": [ @isset($attributes['selectName'] ) {{ $key+1 }} @else {{ $key }} @endisset   ],
                       @isset($column->classStyle)
                           className: "{{ $column->classStyle }} valign-center",
                       @endisset
                       @isset($column->taille)
                           width: "{{ $column->taille }};",
                       @endisset
                   },
                @endforeach
          ],

          //initComplete
          initComplete: (settings, json)=>{
            //deplacer le pignation dans un div donnée en entrer
            @if($attributes['idDivPaginate'])
                $('.dataTables_paginate').appendTo($('#{{ $attributes['idDivPaginate'] }}'));
            @endif

            // deplacer info dans un div donné en entrer
            @if($attributes['idDivInfo'])
                $('.dataTables_info').appendTo($('#{{ $attributes['idDivInfo'] }}'));
            @endif

            // gerer les des case a cocher
            @if($attributes['selectName'])
                gsSelectChange();
            @endif

            // Masquage des group lors du premeier affichage
            @if($attributes['groupBy'])
                defaultCollapse=false;
            @endif

          },
          "order":[[ {{ count($columns) + $init }},'asc']],

          // rowGroup
          @if($attributes['groupByEnable'])
            @if($attributes['groupBy'])
                orderFixed: [[names.indexOf("{{ $attributes['groupBy'] }}"), '']],
            @endif
          rowGroup: {
                 @if($attributes['groupBy'])
                    dataSrc: "{{ $attributes['groupBy'] }}",
                 @else
                    enable: false,
                 @endif

                startRender: function (rows, group) {
                    var collapsed = !!collapsedGroups[group];
                    if(defaultCollapse){
                        collapsed=true;
                        collapsedGroups[group]=true;
                    }
                    var checked = !!checkedGroups[group];


                    //creation du checkox du group
                    let checkbox=document.createElement('input');
                    checkbox.type='checkbox';
                    checkbox.name='select-group';
                    checkbox.style.margin='auto 5px auto 0px';
                    checkbox.className='checkbox-group-dt';
                    checkbox.checked=checked;
                    $(checkbox).on('change',function(e,f){
                        checked= e.target.checked;
                        checkedGroups[group]=checked;
                        if(!f){
                            rows.nodes().each(function (r) {
                                $(r).find(".dataTable-simple-selectItem").each(function(){
                                    $(this).prop("checked",checked);

                                });
                            });
                        }

                        updateSelectAll();

                    });

                    rows.nodes().each(function (r) {
                        r.style.display = collapsed ? 'none' : '';
                        if(collapsed)
                            $(r).addClass('collapsed');
                        let check=$(r).find('.dataTable-simple-selectItem');
                        //check.css('margin-left','10px');
                        if(checked){
                            check.prop("checked",checked);

                        }
                        $(check).on('change',function(){
                            let count=0;
                            rows.nodes().each(function (el) {
                                let jqel=$(el).find('.dataTable-simple-selectItem');
                                if(jqel.get(0)){
                                    if(!jqel.get(0).checked){
                                        count++;
                                    }
                                }

                            });
                            if(count<=0){
                                checkbox.checked=true;

                            }
                            else{
                                checkbox.checked=false;
                            }
                            $(checkbox).trigger('change','fils');;
                        })
                    });


                    let td=document.createElement('td');
                    let div=document.createElement('div');
                    let divLeft=document.createElement('div');
                    let divRight=document.createElement('div');
                    let triangle=document.createElement('span');

                    divLeft.appendChild(checkbox);
                    let text=document.createElement('span');
                    text.innerHTML=group + ' <span class="badge badge-success">' + rows.count() + '</span>';
                    divLeft.appendChild(text);
                    if(collapsed){
                        triangle.innerHTML="&#9654;";
                    }
                    else{
                        triangle.innerHTML="&#9660;";
                    }
                    divRight.appendChild(triangle);
                    div.className="d-flex justify-content-between"
                    div.appendChild(divLeft);
                    div.appendChild(divRight);
                    td.colSpan='{{count($columns)+1}}';
                    td.appendChild(div);
                    return $('<tr/>')
                        .append(td)
                        .attr('data-name', group)
                        .toggleClass('collapsed', collapsed);
                }
          }
          @endif

        });

        //ROWGROUP
        @if($attributes['groupByEnable'])
        // Lors d'une clique sur un group
        $("#{{ $name }} tbody").on('click', 'tr.dtrg-start,checkbox-group-dt', function (e) {
            if(e.target.type=='checkbox'){

            }
            else{
                var name = $(this).data('name');
                collapsedGroups[name] = !collapsedGroups[name];
                {{ $name }}.draw();
            }

        });
        //lors d'un changement du dataSrc du rowGroup
        {{ $name }}.on( 'rowgroup-datasrc', function ( e, dt, val ) {
            disabledAllActions(true);
            collapsedGroups = {};
            defaultCollapse=true;
            checkedGroups = {};
            let index=names.indexOf(val);
            {{ $name }}.order.fixed( {pre: [[ index, 'asc' ]]} ).draw();
            defaultCollapse=false;
        } );
            // {{ $name }}.rowGroup().enable().draw();
            // {{ $name }}.rowGroup().dataSrc('categorie');

        @endif

        // cacher certain colonne
        @foreach($columns as $key=>$column)
            @if(isset($column->visible) && !$column->visible)
                {{ $name }}.column({{ $key+ $init }}).visible(false);
            @endif
        @endforeach
        {{ $name }}.column({{ count($columns) + $init }}).visible(false);



        let x=0;
        let c=0;
        const resizeObserver = new ResizeObserver(entries => {
            let x1=$('#{{ $name }}__tbody').width();
            console.log(entries);
            if(x!=x1 && Math.abs((x-x1))>3  && c==0){
                    x=x1;
                    c=1;
                    setTimeout(function(){
                        c=0;
                        {{ $name }}.columns.adjust().draw();

                    },299);

            }
          console.log('Size changed');
        });
        resizeObserver.observe($("#{{ $name }}__tbody").get(0));
        $("#{{ $name }}__tbody ").resize(function(){





        });

        // constante
        let idAlert='{{ $attributes['idAlert'] }}';
        let actions=[];



        // Activation/desactivation des button d'actions avec canSelect
        function disabledActions(canSelect,masque){
            for(let action of actions){
                if(action.canSelect==canSelect){
                    $('#'+action.id).prop('disabled',masque);
                }
            }

        }
        //activation/desactivation de tous les buttons d'actions
        function disabledAllActions(masque){
            for(let action of actions){
                if(action.canSelect){
                    $('#'+action.id).prop('disabled',masque);
                }
            }
        }


        @if($attributes['selectName'])

            function  saytouActionYi(){
                let count= $(selectNameSelector).filter(':checked').length ;
                    disabledAllActions(true);
                    if(count==1){
                        disabledAllActions(false);
                    }
                    else if(count>1){
                        disabledActions('1',true);
                        disabledActions('*',false);
                    }
            }

            function updateSelectAll(){
                let count= $(selectNameSelector).filter('input:checkbox:not(":checked")').length ;
                if(count>0){
                    $("#{{ $name }} .dataTable-simple-selectAll").prop('checked',false);
                }
                else{
                    $("#{{ $name }} .dataTable-simple-selectAll").prop('checked',true);
                }
            }

            function gsSelectChange(){
                $(selectNameSelector+' , #{{ $idSelectAll }}').change(function(e){
                    saytouActionYi();
                    updateSelectAll();
                });
            }
            gsSelectChange();

            {{ $name }}.on('draw',function(){

                saytouActionYi();
                gsSelectChange();
            });


        @endif

        // Alerter
        function alerter(btn_data,title,message,success){
            if(btn_data.typeAlert=='modal'){
                let type = (success)?'bg-success text-white':'bg-danger text-white';
                let modalAlert=$.fn.nplModalAlert({
                            id:'modal_alert',
                            text:message,
                            type:type,
                            title:title,
                            data:btn_data,
                        });
                modalAlert.modal('show');
                modalAlert.on('hidden.bs.modal',function(){
                    $(this).modal('dispose');
                })
            }
            else{
                let classAdded='alert alert-success';
                let classRemoved='alert alert-danger';
                if(!success){
                    let t=classAdded;
                    classAdded=classRemoved;
                    classRemoved=t;
                }
                $.fn.nplAlertShow(idAlert,title+' : '+message,classAdded,classRemoved,2.5);
            }
        }

        // Les Actions
        @if($attributes['actions'])
            actions=@json($attributes['actions']);

            //definition de la function ajax
            function ajaxAction(btn_data){
                if(!btn_data.method){
                    btn_data.method='get';
                }
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                console.log($('#{{ $name }} .dataTable-simple-selectItem').serializeObject());
                $("#modal__dt").bind('hidden.bs.modal', function (e) {
                            $(this).remove();
                });
                $.ajax({
                    url: btn_data.url,
                    type: btn_data.method,
                    data:$('#{{ $name }} .dataTable-simple-selectItem').serializeObject(),
                    dataType: "json",
                    success: function (response) {
                        $("#modal__dt").on('hidden.bs.modal', function (e) {
                                $("#modal__dt").remove();
                        });
                        $("#modal__dt").modal('hide');

                        if(response.status){
                            alerter(btn_data,'Operation effectuée '+btn_data.op,response.message,true);
                            disabledAllActions(false);

                            {{ $name }}.ajax.reload();
                        }
                        else{
                            alerter(btn_data,'Echec Opération '+btn_data.op,response.message,false);
                        }
                    },
                    error: async function (err){

                        await $("#modal__dt").modal('hide');
                        alerter(btn_data,'Echec Opération '+btn_data.op,'Ressource Indisponible, Vérifier la connexion',false);
                    }
                });
            }
            // Lors d'un clique sur un button btn_data
            function onClickBtnAction(btn_data){
                $("#"+btn_data.id).on('click',function(e){
                    if(btn_data.confirm){
                        let modalConfirm=$.fn.nplModalConfirm({
                            id:'modal__dt',
                            text:'Êtes vous sûre de vouloir continuer l\'operation '+btn_data.op,
                            type:'panel-warning',
                            title:btn_data.op ,
                            data:btn_data,
                            fonction: ajaxAction
                        });
                        modalConfirm.modal('show');
                    }
                    else{
                        ajaxAction(btn_data);
                    }

                });
            }

            //lors d'un clique sur un lien btn_data
            function onClickBtnLink(btn_data){
                $("#"+btn_data.id).on('click',function(e){
                    let selectedInput = $(selectNameSelector).filter(':checked');
                    if(selectedInput.length == 1){
                        window.location.href=btn_data.url.replace('{id}',selectedInput[0].value);
                    }
                });
            }

            function onClickBtnTrigger(btn_data){
                $("#"+btn_data.id).on('click',function(e){
                    let selectedInput = $(selectNameSelector).filter(':checked');
                    let allValueSelected=[];
                    selectedInput.each(function (index, element) {
                        allValueSelected.push(element.value);
                        
                    });
                    $(this).trigger('click_for_dt',allValueSelected);
                });
            }

            //Enregistrement des Actions
            for(action of actions){
                if(action.type=='action'){
                    onClickBtnAction(action);
                }
                else if(action.type=='link'){
                    onClickBtnLink(action);
                }
                else if(action.type=='trigger'){
                    onClickBtnTrigger(action);
                }
            }


        @endif
    });

</script>

@endpush
