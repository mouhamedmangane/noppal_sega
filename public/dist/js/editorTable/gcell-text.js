$(function(){
    // GCell Input
    $.fn.NplEditorTable.GCellText = function(ob){
        $.fn.NplEditorTable.GCell.call(this,ob);
        this.createInput=function(i,value){
            let input = document.createElement('input');
            input.name=this.name+'[]';
            input.type=this.options.type;
            input.value=value;
            input.className=this.classNameInput+' form-control';
            let editor=this.editorTable;
            this.pushAllEvent(input,i);
            return input;
        };
        this.updateInput=function(i,value){
            let inputs = this.inputs();
            if(inputs){
                inputs.get(i).value=value;
            }
            else{
                throw new Exception("Impossible de selectionner la ligne "+i+" colonne "+this.name);
            }

        };

    };

    $.fn.NplEditorTable.GCellText.prototype = Object.create($.fn.NplEditorTable.GCell.prototype);
    $.fn.NplEditorTable.GCellText.prototype.constructor = $.fn.NplEditorTable.GCellText;

});
