<div style=""  class="toolbar border-bottom d-flex justify-content-between align-items-center px-4">
    <div class=" d-flex ">
        <x-npl::input.button-submit  id="test-button-submit"
                                        idForm="addProduct"
                                        idContentAlert="addProduitAlert"
                                        class="btn btn-primary btn-sm d-flex align-items-center"
                                        text="Enregistrer"
                                        isReset="true"                                       
                                    
                                        {{-- hrefId="/produit/list" --}}
                                        parentMessageClass="n-form-table-col-input"
                                        elementMessageClass="form-table-feedback"
                                        icon="save"/>
        <button class="btn btn-sm btn-outline-danger d-flex align-items-center  ml-2" type="reset" >
            <i class="material-icons-outlined " style="font-size:16px;">delete</i>
            <span class="ml-1"> Annuler</span>       
        </button>
    </div>
</div>