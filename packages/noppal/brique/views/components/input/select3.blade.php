<div class="position-relative select3 {{ $attributes['class'] }} p-0">
    <input type="text"  
            class="form-control select3-input m-0" style="{{$attributes['style']}}"
            @if($attributes['required'] && $attributes['required']=='true')
                    required 
            @endif
            placeholder="{{$attributes['placeholder']}}"
            @if($attributes['disabled'] && $attributes['disabled']=='true')
                disabled
            @endif/>

    <ul class="position-absolute overflow-auto select3-rs list-group w-100  border " style="display:none;"
        >
        @foreach ($dt as $key=>$text )
            <li data-valeur="{{ $key }}" data-mytext="{{$text}}"
                class="focusable-element select3-item list-group-item border-0" style="cursor: pointer;"  
                aria-selected="true"
                   >
                {{ $text }}
            </li>
        @endforeach
    </ul>

    <select class="d-none" name="{{$name}}" value="{{$value}}" >
        <option value="0" class="d-none" style="visibility: hidden;"></option>
        @foreach ($dt as $key=>$text )
            <option value="{{ $key }}" 
                    @if ($key == $value) 
                        selected="true"
                    @endif>
                {{ $text }}
            </option>
        @endforeach
    </select>
</div>

@push('script')

<script type="text/javascript">
    $(document).ready(function(){

        function colorTextSearch(text,search){
            let index=text.toUpperCase().indexOf(search.toUpperCase());
            let indexAfter=index+search.length-1;
            html='<span>'+text.substring(0,index)+"</span>";
            html+='<span class="color-text-search">'+text.substring(index,indexAfter+1)+"</span>";
            html+='<span class="">'+text.substring(indexAfter+1,text.length)+"</span>";
            return html;
        }

        let estCliquer=false;
        $('.select3-input').on('focus',function(){
                let parent=$(this).parent();
                parent.children('.select3-rs').show();
                estCliquer=false;
            
        });
        $('.select3-input').on('blur',function(){
            let parent=$(this).parent();
            setTimeout(() => {
                if(estCliquer==false){
                    parent.children('.select3-rs').hide();
                }
            }, 200);
            
            
        });
        function activeItem(item){
                console.log(item.html());
                estCliquer=true;
                let parent =  item.parent().parent();
                let input= parent.children('.select3-input');
                input.val(item.data('mytext'));
                input.addClass('active');
                console.log(item.data('mytext'));
                console.log(item.data('valeur'));
                parent.children('select').val(item.data('valeur'));
                parent.children('.select3-rs').hide();
        }
        
        function addEventClickItems(){
            $('.select3-item').on('click',function(e){
                activeItem($(this));
            });
        }
        $('.select3-input').each(function(index,element) {
            
            let selected=$(element).siblings('select').children(':selected');
            console.log(selected.html());
            if(selected.length>=0 && selected.val()>0){
                selected.parent().siblings('.select3-rs').children('.select3-item').each(function(i,el){
                    if($(selected).prop('value')==$(el).data('valeur')){
                        console.log('pppppppppppppp');
                        console.log($(el).data('valeur'));
                        activeItem($(el));
                    }
                })
               
            }
        });
        addEventClickItems();
        $(".select3-input").on('keyup',function(){
            estCliquer=false;
            $(this).removeClass('active');
            let search=$(this).val();
            let searchword=search.split('/');
            let parent=$(this).parent();
            parent.children('select').val(0);
            let rs=parent.children('.select3-rs');
            rs.show();
            rs.html(' ');
            let cpt=0;
            parent.find('option').each(function(index,element){
                if(element.value!=0){
                    if(element.innerHTML.toUpperCase().indexOf(search.toUpperCase())>=0 || search.length==''){
                        rs.append('<li data-valeur="'+element.value+'" data-mytext="'+element.innerHTML+'" class="list-group-item select3-item focusable-element border-0" style="element">'+colorTextSearch(element.innerHTML,search)+'</li>');
                        cpt++;
                    }
                    if(element.innerHTML.trim()==search.trim() && search.length>0){
                        activeItem($(element));
                    }
                }
            });
            if(searchword.length>1){
                parent.find('option').each(function(index,element){
                    if(element.value!=0  && searchword[searchword.length-1].length>0){
                        if(element.innerHTML.toUpperCase().indexOf(searchword[searchword.length-1].toUpperCase())>=0){
                            rs.append('<li data-valeur="'+element.value+'" data-text="'+element.innerHTML+'" class="list-group-item select3-item focusable-element border-0" style="element">'+colorTextSearch(element.innerHTML,searchword[searchword.length-1].trim())+'</li>');
                                cpt++;
                        }
                    }
                });
            }

            if(cpt>0){
                addEventClickItems();

            }else{
                rs.append('<li data-value="-1" class="list-group-item  d-flex align-items-center">\
                    @if ($attributes['redirect'])
                        <a href="{{$attributes['redirect']}}/'+ search +'" class="lien-sp">\
                            @if($attributes['redirect_icon'])
                                <i class="material-icons mr-1 bg-primary text-white rounded-circle p-2">{{$attributes['redirect_icon']}}</i>\
                            @endif
                            {{$attributes['redirect_text']}}\
                        </a>\
                    @else
                        aucun resultat \
                    @endif
                    </li>');

            }
        });

      
       
    });
</script>

@endpush