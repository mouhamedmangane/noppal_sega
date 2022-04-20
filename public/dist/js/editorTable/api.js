
$(function(){

    $.fn.NplEditorTable={};

    // Constantes
    $.fn.NplEditorTable.defaultClassTr ='npl-editor-tr';
    $.fn.NplEditorTable.defaultClassTd ='npl-editor-td';
    $.fn.NplEditorTable.defaultClassInput ='npl-editor-input';


    $.fn.NplEditorTable.Api =  function(id,ob){
        this.selector = "#"+id;
        this.data=ob.data;
        this.columns=ob.columns;
        this.hideColumns=ob.hideColumns;
        this.columns.push(new $.fn.NplEditorTable.GcellSup({
            name:'sup__col',
        }));
        this.eventInputs=[];
        // init column
        for (const column of this.columns) {
            column.editorTable=this;
        }

        this.count = ( )=>{
            return this.data.length;
        }

        this.getColumn = (name)=>{
            if(Number.isInteger(name)){
                if(name>=0 && name<this.columns.lenght)
                    return this.columns[name];
                else
                    throw new Exception('column '+name+' n existe pas');
            }
            else{
                return this.columns.find((col) => col.name == name);
            }

        };
        this.drawRow=function(item,i){
            let tr = document.createElement('tr');
            tr.className=$.fn.NplEditorTable.defaultClassTr;
            for (const column of this.columns) {
                let input=column.createCell(item[column.name],i);
                tr.appendChild(input);
            }

            return tr;

        }

        this.draw=function(){

            let tbody=$(this.selector).children('tbody');
            let i=0;
            for (const item of this.data) {
                let tr=this.drawRow(item,i);
                $(tr).find('.select2').select2();
                tbody.append(tr);

                i++;
            }


        };
        this.updateInput=(i,name,value)=>{
            this.getColumn(name).update(i,value);
        };
        this.update =async ()=>{
            for (const column of this.columns) {
                await column.update();
            }
            this.trigger('update',{});
        };
        this.updateRow =async (i)=>{
            for (const column of this.columns) {
                await column.updateRow(i);
            }
            for (const column of this.columns) {
                column.trigger('update-item',{value:column.getCellValue(i),rowIndex:i });

            }
            this.trigger('update',{});
        };
        this.getTr=function(i){
            return $(this.selector).find('.'+$.fn.NplEditorTable.defaultClassTr).get(i);
        };
        this.getTd=function(i,name){
            return $(this.selector).find('.'+$.fn.NplEditorTable.defaultClassTD+'"'+name+'"]').get(i);
        };
        this.getInput=function(i,name){
            return this.getColumn(name).inputs().get(i);
        };
        this.getInputValue=(columnName,rowIndex)=>{
            let row=this.data[rowIndex];
            return row[columnName];
        }

        this.newEmptyData=function(){
            let data={};
            for (const column of this.columns) {
                data[column.name] = column.defaultValue;
            }
            return data;
        };

        this.addEmptyRow=function(row){
            if(!row)
                row= this.newEmptyData();
            this.data.push(row);
            let tr=this.drawRow(row,this.data.length-1);
            let tbody=$(this.selector).children('tbody');
            $(tr).find('.select2').select2();

            tbody.append(tr);

        };

        this.removeRow=(i)=>{
            this.data.splice(i,1);
            let tr= this.getTr(i);
            tr.remove();
            this.update();
            this.trigger('delete-row',{row:i});
        }
        this.trigger=(name,ob)=>{
            for(const event of this.eventInputs){
                if(event.name==name){
                    event.fonction(ob);
                }

            }
        }
        //event
        this.on=(eventName,fonction)=>{
            this.eventInputs.push({name:eventName,fonction:fonction});
        }
        this.draw();
        for (const column of this.columns) {
            column.afterSetEditor() ;
        }

    };

    $.fn.NplEditorTable.Intances=[];
    $.fn.extend({
        nplEditorTable:function(ob=null){
            let api = $.fn.NplEditorTable.Intances.find((instance)=>{
               return  instance.selector == ('#'+this.prop('id'))
            } );
            if(!api){
                api = new $.fn.NplEditorTable.Api(this.prop('id'),ob);
                $.fn.NplEditorTable.Intances.push(api);
            }
            return api;


        },
    });




});
