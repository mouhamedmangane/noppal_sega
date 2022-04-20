$(function(){
    $.fn.NplEditorTable.GCell = function(ob){
        this.name=ob.name;
        this.options=ob.options;
        this.classNameInput= $.fn.NplEditorTable.defaultClassInput;
        this.classNameTd= $.fn.NplEditorTable.defaultClassTd;
        this.isVisible=ob.visible;
        this.refName=ob.name;
        this.eventColumn=[]//evenement pour la collonne
        if(ob.refName)
            this.refName=ob.refName;

        this.defaultValue= undefined;
        if(ob.options){
            this.defaultValue= ob.options.defaultValue;
        }
        // data et table
        this.editorTable=null;
        this.getCellValue=(index)=>{
            let row=this.editorTable.data[index];
            return row[this.name];
        }
        this.setCellValue=(index,value)=>{

            let row =  this.editorTable.data[index];
            row[this.name]=value;
        }
      ;
        // inputs
        this.createInput=undefined;
        this.updateInput=undefined;
        this.inputs= function(){
            if(this.editorTable)
                return $(this.editorTable.selector).find('.'+this.classNameInput+'[name="'+this.name+'[]"]');
            else
                throw new Exception("editorTable de la colonne est undefined");
        };

        this.on=(eventName,fonction)=>{
            this.eventColumn.push({name:eventName,fonction:fonction});
        }

        this.trigger=(name,ob)=>{
            for(const event of this.eventColumn){
                if(event.name==name){
                    event.fonction(ob);
                }

            }
        }

        this.update = function(){
            let inputs=this.inputs();
            inputs.off();
            let trigger= this.trigger;
            let fngetDataCell =this.getCellValue;
            let fnPushAll = this.pushAllEvent;
            inputs.each(function(index,element){
                element.value= fngetDataCell(index);
                trigger('update-item',{value:fngetDataCell(index)});
                fnPushAll(element,index);
                if($(element).hasClass("select2")){
                    $(element).select2();
                }
            });
        };

        this.updateRow = function(i){

            let element= this.inputs().get(i);
            $(element).off();
            element.value= this.getCellValue(i);
            this.pushAllEvent(element,i);
            if($(element).hasClass("select2")){
                $(element).select2();
            }
        };


        //Cellule
        this.createCell=(value,i)=>{
            let td= document.createElement('td');
            td.className=this.classNameTd+' '+ob.classTd;
            let input=this.createInput(i,value);
            input.className+=' '+ob.classInput;
            td.appendChild(input);
            return td;
        }

        //table editor

        this.setEditorTable=function(editorTable){
            this.editorTable = editorTable;
        };
        this.afterSetEditor=()=>{};

        //Event Input
        this.eventInputs=[];
        this.addEventInputBefore=(eventName,fonction)=>{
            this.eventInputs.push({name:eventName,fonction:fonction});

        };
        // permet d'enregistrer un evenment apres l'affectation a l' api
        this.addEventInput=(eventName,fonction)=>{
            this.addEventInputBefore(eventName,fonction);
            let elements= this.inputs();
            let column =this;
            elements.each(function (index, element) {
                column.pushEvent(element,{name:eventName,fonction:fonction},index);
            });
        };
        // cette fonction permet d'appliquer un evement passer en parametre a un input
        this.pushEvent=(input,eventI,rowIndex)=>{
            let column=this;
            let editorTable=this.editorTable;
            if(eventI){
                $(input).on(eventI.name,function(e){
                    e.column= column;
                    e.editorTable= editorTable;
                    e.rowIndex=rowIndex;
                    eventI.fonction(e);
                 });
            }
            else{
                throw new Exception('impossible de recuperer la fonction de l evement il se peut que le nom de l evement donné n est pas bonn' )
            }

        };
        //cette fonction permet d'appliquer toutes les evenement a un input s
        this.pushAllEvent=(input,rowIndex)=>{
            for (const eventInput of this.eventInputs ) {
                this.pushEvent(input,eventInput,rowIndex);
            }
        };
        // permet d'enregistrer des evements au sein des Gcell avant meme
        // de renseigner le tableau
        this.addEventInputBefore('change',function(e){
            e.column.setCellValue(e.rowIndex,e.target.value);

        });

        //cette fonction permet recuperer les donnres d'une cellule
        this.getDataCell=(rowIndex)=>{

        };

    };

    $.fn.NplEditorTable.GcellSup = function(ob){
        $.fn.NplEditorTable.GCell.call(this,ob);
        this.eventInputs=[];
        this.classNameInput='npl___editor___sup___row';
        this.inputs= function(){
            if(this.editorTable)
                return $(this.editorTable.selector).find('.'+this.classNameInput);
            else
                throw new Exception("editorTable de la colonne est undefined");
        };
        this.createInput=function(i,value){
            let input = document.createElement('button');
            input.innerHTML='<i class="material-icons md-20">delete</i>'
            input.className=this.classNameInput+' ml-1 btn btn-sm btn-outline-secondary hv-danger-btn-oultline';
            input.style.fontSize='14px';
            this.pushAllEvent(input,i);
            return input;
        };
        this.update = function(){
            let inputs=this.inputs();
            inputs.off();
            let fnPushAll = this.pushAllEvent;
            inputs.each(function(index,element){
                fnPushAll(element,index);
            });
        }

        this.addEventInputBefore('click',function(e){
          e.editorTable.removeRow(e.rowIndex);
        });


    };
    $.fn.NplEditorTable.GcellSup.prototype = Object.create($.fn.NplEditorTable.GCell.prototype);
    $.fn.NplEditorTable.GcellSup.prototype.constructor = $.fn.NplEditorTable.GcellSup;

});
