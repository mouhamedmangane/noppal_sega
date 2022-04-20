$(function(){
    //afterLoadVente
    $.AfterLoadDataTable={};

    jQuery.fn.extend({
        try_component: function(my_method){
            return this.each(function(){
                let div =document.createElement('div');
                div.className="try_again superposistion d-flex justify-content-center align-items-center";
                let text = document.createTextNode("Echec Requete ...");
                let button = document.createElement('button');
                button.innerHTML="Réessayer";
                button.className ="btn btn-secondary";
                button.addEventListener('click',my_method);
                button.type='button';
                div.appendChild(text);
                div.appendChild(button);
                $(this).html('').append(div);
            });
        },

        loading:function(){
            return this.each(function(){
                let div =document.createElement('div');
                div.className = "loading superposistion d-flex justify-content-center align-items-center";
                $(div).html('<div class="spinner-border" role="status"> \
                        <span class="sr-only">Loading...</span> \
                    </div>');

                $(this).append($(div));
            });
        },

        serializeObject : function()
        {
           var o = {};
           var a = this.serializeArray();
           $.each(a, function() {
               if (o[this.name]) {
                   if (!o[this.name].push) {
                       o[this.name] = [o[this.name]];
                   }
                   o[this.name].push(this.value || '');
               } else {
                   o[this.name] = this.value || '';
               }
           });
           return o;
        },

        //
        updateProfilImage:function(selectorTarget){
            return this.each(function(){
                let file = $(this)[0].files[0];
                $(selectorTarget).attr('src',URL.createObjectURL(file));
            });
        },
        ajaxPush:function(url){
            let form=this;

            $(this).find(':input').on('change',function(){
                console.log( $(form).serialize())
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: url,
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        if(response.status){
                        }
                    }
                });
            });
            return $(this);
        }

    });


//    les arlert
    $.fn.nplAlertShow= function (idContentAlert,message,typeClass,removeClass,fade=0){
        idContentAlert="#"+idContentAlert;
        $(idContentAlert).removeClass(removeClass);
        $(idContentAlert).html(message);
        $(idContentAlert).addClass(typeClass);
        $(idContentAlert).fadeIn();
        if(fade!=0){
            $(idContentAlert).delay(fade*2000).fadeOut(500);
        }

    };
    $.fn.nplAlertHide = function(idContentAlert){
        $('#'+idContentAlert).alert('close');
    };

    $.fn.nplAlertBarShow = function(idContentAlert,message,typeClass,removeClass,fade=0){
        $(idContentAlert).removeClass(removeClass);
        $(idContentAlert).html(message);
        $(idContentAlert).addClass(typeClass);
        $(idContentAlert).fadeIn();
        if(fade==1){
            $(idContentAlert).delay(2000).fadeOut(500);
        }

    };

    // show and hide dropdown
    $(function(){

        $('.ddw-cacha').on('show.bs.dropdown',function(){
               $('.cacha').css('z-index','-10');
        });
        $('.ddw-cacha').on('hide.bs.dropdown',function(){
               $('.cacha').css('z-index','auto');
        });
    });

    // Filter & Search add filter tosearch
    // NB : class_name avec point
    $.pushFilterToSearch=(idSearch,idElement,idChecks,name,values,titre,text,class_name='')=>{
        let textHtml='';
        for (const k in values) {
            let x=k;
            let nameValue='';


            if(Array.isArray(values[k])){
                nameParent=name+'['+k+']';
                let valueChild=values[k];
                loop1:
                for(const o of valueChild.keys()){
                    if(Array.isArray(o)){
                        valueChild=valueChild[o];
                        nameParent+='['+o+']';
                        continue loop1;
                    }
                    nameValue=nameParent+'[]';
                    textHtml +="<input type='hidden' name='"+nameValue+"' value='"+valueChild[o]+"'>";
                }
            }
            else{
                textHtml +="<input type='hidden' name='"+name+"["+k+"]' value='"+values[k]+"'>";
            }


        }
         textHtml +=  "                               \
                <span class='search-item-title bg-success pl-2 pr-1  py-1'>"+titre+": </span>\
                <span class='search-item-text py-1 px-2 no-wrap'>"+text+"</span>\
                <button class='search-item-close btn btn-secondary' type='button' data-id-check='"+idChecks+"'><i class='material-icons md-14'>close</i></button>\
        ";
        if($('#'+idElement).length)
            $('#'+idElement).html(textHtml)
        else
            $(idSearch).append(
                "<div id='"+idElement+"' class='search-item mx-1 rounded-pill '> "
                +textHtml+
                "</div> "
             );
        console.log(idSearch);
        $(idSearch).trigger('n-resize');
        $('#'+idElement).find(".search-item-close").bind('click',function(){
                if(!class_name.length){
                    console.log(idChecks+" ");
                    $(idChecks).prop('checked',false);
                    $(idChecks).trigger('change');
                }
                else{
                    console.log(idChecks+" "+class_name);
                    $(idChecks).find(class_name).prop('checked',false);
                    $(idChecks).find(class_name).trigger('change');
                }

        });
    };


    $.removeFilterToSearch=(idElement,idSearch)=>{
        $(idElement).remove();
        if($(idSearch))
            $(idSearch).trigger('n-resize');
    };





    //Chargement
    $.chargementActive=false;
    $.chargement=function(){
        if($.chargementActive==false){
        $('#content').append('<div id="apieditorchargement" \
                                    class="position-absolute w-100 "\
                                    style="top:0px;left:0px;height:calc(100vh - 48px);background:rgba(0,0,0,0.3);"\
                              ></div>');
        $('#content').append('<div id="apieditorchargementmessage" \
                                    class="position-absolute  text-align-center px-4 py-2"\
                                    style="top:calc(50% - 20px);left:calc(50% - 125px);background:white;color:black; width:300px;text-align:center;">\
                                    Requete Asynchrone chargment ...\
                             </div>');
                             $.chargementActive=true;
        }
    };
    $.rmchargement=function(){
        $('#apieditorchargement').remove();
        $('#apieditorchargementmessage').remove();
        $.chargementActive=false;

    };


    //dropdown tb
    $('.btn-tb-down').on('click',function(){
        if($(this).next().hasClass('cacher')){
            var point=$(this).offset();
            var widthWindows=$( window ).width();
            console.log(point);
            console.log(widthWindows);
            let diff=widthWindows - point.left;
            if(point.left<widthWindows/2 || (diff>0 && diff > $(this).next().outerWidth()) ){
                $(this).next().css('left',point.left)
            }
            else{
                $(this).next().css('left',point.left+$(this).outerWidth()-$(this).next().outerWidth());
                console.log('right')
            }
            $(this).next().css('top',point.top+35)
        }
        $(this).next().toggleClass('cacher');


    });

    // dipairaitre si on me clique pas
    $(document).on("click", function(event){
        var trigger = $(".facile");
        console.log(trigger);
        trigger.each(function (index, element) {
            console.log(element);
            console.log(element !== event.target);
            console.log($(element).has(event.target).length);
            if(!$(element).parent().has(event.target).length && element !== event.target && !$(element).has(event.target).length){
               $(element).addClass('cacher');

            }
        });
    });


});
