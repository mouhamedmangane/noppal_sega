
$(function(){
    $.fn.NplEditorTable.GCellSelect = function(ob){

        $.fn.NplEditorTable.GCell.call(this,ob);
        this.defaultOption = ob.options.defaultOption;
        this.defaultValue = ob.options.defaultOption.value;
        this.valueProp = ob.valueProp;
        this.textProp = ob.textProp;
        this.data=ob.data;
        this.unique=false;
        if(ob.options.unique){
            this.unique=ob.options.unique;
        }


        this.dataRestant= async function(i){
            let name = this.refName;
            let propValue=this.valueProp;
            let data= $.map(this.editorTable.data,function(o){return o[name]});
            let optionsData =await this.optionsSelectData(i)
            let toutesLesValeurs = $.map(optionsData,function(o){return o});
            if(this.unique==true){
                let valeurADessines=toutesLesValeurs.filter((o)=> {

                    let value=o[propValue]+"";

                    return ($.inArray(value,data)==-1 || (value==data[i] && data[i]));
                 });
                return $(valeurADessines);
            }
            else{
                return $(toutesLesValeurs) ;
            }

        };

        this.optionsSelectData = async function(i){
            let tab=this.data;
            if(tab){
                return tab;
            }
            else{
                 return [];
            }

        };
        this.createOption=function(item,value,getValue,getText){


            let valueIpt=item[getValue];
            let text=item[getText];
            let option=document.createElement('option');
            option.value=valueIpt ;
            let optionText = document.createTextNode(text);
            option.appendChild(optionText);
            // if(getText=="nom")
            // alert(value+' '+valueIpt);

            if(value==valueIpt && value){
                option.selected=true;
            }

            return option;
        };


        this.updateElementOption=async function(restant,element,value,i){

            let optionDefault=this.createOption(this.defaultOption,'','value','text');
            optionDefault.selected=false;
            let fnCreateOption = this.createOption;
            let valueProp =this.valueProp;
            let textProp = this.textProp;
            if(element){
                try {
                    let dt = await restant;
                    if(dt){
                        element.innerHTML="";
                        let isNotValue=true;
                        element.prepend(optionDefault);
                        for (const item of dt) {
                            element.appendChild(fnCreateOption(item,value,valueProp,textProp));

                            if(value==item[valueProp] && value){

                                isNotValue=false;
                            }
                        }
                        if(isNotValue){
                            optionDefault.selected=true;
                        }
                    }
                } catch (error) {
                   // alert("la connexion n'est pas bonne, alors les données ne sont pas recuperées au niveau du serveur.\nVeuiller revoir votre connexion et retenter l'action !");
                }

            }




        };

        this.createInput=function(i,value){
            let restant =  this.dataRestant(i);
            let select= document.createElement('select');
            select.name= this.name+'[]';
            select.value=value;
            select.style.width="100%";
            select.className=this.classNameInput+'  custom-select';
            this.updateElementOption(restant,select,value,i);
            this.pushAllEvent(select,i);

            return select;
        };

        this.updateInput=function(i,value){
            let restant =  this.dataRestant(i);
            let select=this.inputs().get(i);
            this.updateElementOption(restant,select,value,i);
            return select;
        };


        this.update = async function(){
            let inputs=this.inputs();
            inputs.off();

            for (let index = 0; index < this.editorTable.data.length; index++) {
                let restant = await  this.dataRestant(index);

                let element = inputs.get(index);

                value = this.getCellValue(index);
                if(value && element){
                    element.value=value;
                }
                else{
                    value='';
                }
                this.updateElementOption(restant,element,value,index);


                if(element){
                    this.pushAllEvent(element,index);
                    this.trigger('update-item',{value:value});

                }


            }
        };



        this.addEventInputBefore('change',function(e){
            e.column.update();
        });

        this.getDataCell=(rowIndex)=>{
            let valueCellDep = this.editorTable.getInputValue(this.nameDep,rowIndex);
            let valueCell= this.editorTable.getInputValue(this.name,rowIndex);
            let dataCell=null;
            for(const row of this.data){
                if(row[this.valueProp] == valueCell){
                    dataCell=row;
                    break;
                }

            }
            return dataCell;
        };

    };

    $.fn.NplEditorTable.GCellSelect.prototype = Object.create($.fn.NplEditorTable.GCell.prototype);;
    $.fn.NplEditorTable.GCellSelect.prototype.constructeur = $.fn.NplEditorTable.GCellSelect;




    // columnSelectFree
    $.fn.NplEditorTable.GCellSelectFree=function(ob){
        $.fn.NplEditorTable.GCellSelect.call(this,ob);
        this.nameDep=ob.nameDep;
        this.urlDep = ob.urlDep;

        this.optionsSelectData = async function(i){
            let rowData=this.editorTable.data[i];
            let valueDep=rowData[this.nameDep];
            let tab=this.data[valueDep];
            if(!tab && valueDep){
                $.chargement();
                let response= await this.getOptionAjax(valueDep);
                $.rmchargement();
                this.data[valueDep]=response.data;
                return response.data;
            }
            else{
                return tab;
            }

        };
        this.getOptionAjax=(valueDep)=>{
            return $.ajax({
                type: 'get',
                url: this.urlDep+'/'+valueDep,
                dataType: "json",
            });

        };

        this.afterSetEditor=()=>{
            if(!this.once){
                let name=this.name;
                this.editorTable.getColumn(this.nameDep).addEventInput('change',function(e){
                    //alert('bonjour');
                    e.editorTable.getColumn(name).update();
                });
            }

            this.once=true;
        }

        this.getDataCell=(rowIndex)=>{
            let valueCellDep = this.editorTable.getInputValue(this.nameDep,rowIndex);
            let valueCell= this.editorTable.getInputValue(this.name,rowIndex);
            let dataCell=null;
            for(const row of this.data[valueCellDep]){
                if(row[this.valueProp] == valueCell){
                    dataCell=row;
                    break;
                }

            }
            return dataCell;
        };


    };
    $.fn.NplEditorTable.GCellSelectFree.prototype = Object.create($.fn.NplEditorTable.GCellSelect.prototype);;
    $.fn.NplEditorTable.GCellSelectFree.prototype.constructeur = $.fn.NplEditorTable.GCellSelectFree;

});
