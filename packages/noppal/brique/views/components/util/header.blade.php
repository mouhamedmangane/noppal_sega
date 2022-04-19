<div class="header d-flex align-items-center w-100 justify-content-between">
    <div class="header-title-group " style="" >
        <span class="title-app d-flex">
            <span class="nav-v-item-container-icon masque-sm">
                <i class="material-icons-outlined " style="font-size:24px;">nature_people</i>
            </span>
            <button class="btn text-white masque-md" type="button" id="btn-toggle-sidebar-sm">
                <i class="material-icons nav-v-icon">menu</i>
            </button>

            <span style="margin: 0px 2px;" class="header-title flex-grow-1" id="name_app_bloc">
                <span class="" id="name_app">NOPPAL</span>   
            </span>

            

        </span>
    </div>


    <div class="ml-1 header-content d-flex justify-content-end align-items-center">

        <div class="d-flex justify-content-between m l-4" >

                {{-- <div class="input-in " style="height: 30px;width:300px;">
                    <input type="text" name="search"
                            placeholder="Search"
                            class="form-control  input-in-input"
                            >
                    <div class="input-in-in">
                        <i class="fas fa-search " style="font-size: 12px;"></i>
                    </div>
                </div> --}}
                {{-- <a href="{{ url('home') }}" class="btn btn-outline-primary mx-npl::5">
                    <i class="material-icons-outlined " style="font-size:24px;">home</i>
                </a> --}}

        </div>

        <x-npl::util.headBarAction.bar/>
    </div>
</div>
@push('script')
<script type="text/javascript">
    $(document).ready(function()
    {
        // $('#btn-toggle-sidebar-sm').on('click',function(){
        //     $("#sidebar").removeClass('sidebar-toggle');
        //     $("#sidebar").toggleClass('sidebar-toggle-sm');

        // });
        // $("body").on('click',function(e){
        //     if(!$(e.target).is("#btn-toggle-sidebar-sm")){
        //         $("#sidebar").removeClass('sidebar-toggle');
        //         $("#sidebar").toggleClass('sidebar-toggle-sm');
        //     }
        //     else{
        //         $("#sidebar").removeClass('sidebar-toggle-sm');
        //     }
            
        // });
        $(document).on("click", function(event){
            var $trigger = $("#btn-toggle-sidebar-sm");
            if($trigger.get(0) !== event.target && !$trigger.has(event.target).length){
                $("#sidebar").removeClass('sidebar-toggle-sm');
            } 
                       
        });

        $("#btn-toggle-sidebar-sm").on('mousedown',function(){
            console.log('test');
            $("#sidebar").removeClass('sidebar-toggle');
            $("#sidebar").toggleClass('sidebar-toggle-sm');
        });

      
        
        

    });

</script>

@endpush