<div id="head-bar-action-user" class="head-bar-action-content-item">
    <div class="my-3">
    <div class="d-flex justify-content-center ">
        <div class="" style="position: relative;">
            <img src="{{ URL::asset($photo_profil) }}" alt="" width="80px" height="80px"  class="rounded-circle n__profil_user_class" >

            <div style="position: absolute;width:32px;height:32px;line-height:29px;right:-10px;bottom:-10px;"
                 class="rounded-circle bg-white text-center nav-link-primary text-secondary">
                 <x-npl::input.show-ajax-modal
                     :url="url('photo_form')"
                     idModal="modal_change_photo"
                     class="">
                    <i class="material-icons" style="font-size: 16px;">camera_alt</i>
                </x-npl::input.show-ajax-modal>
            </div>
        </div>
    </div>
    <div class="my-1 mt-2">
        <div class="text-center  font-weight-bold ">{{ $user->name }}</div>
        <div class="text-center ">{{ $user->login }}</div>

    </div>
</div>
    <div class="list-group ">
        <x-npl::input.show-ajax-modal
                     :url="url('profil_form')"
                     idModal="modal_profil_form"
                     class="list-group-item  border-left-0 border-right-0 link-primary">
            <span  class="nav-link-primary link-primary">
                <i class="material-icons-outlined mr-2">edit</i>
                Modifier Profil
            </span>
        </x-npl::input.show-ajax-modal>

        <form method="POST" action="{{ route('logout') }}" class="list-group-item border-left-0 border-right-0">
            @csrf
            <a href="" class="nav-link-primary " onclick="event.preventDefault();
            this.closest('form').submit();">
                <i class="material-icons-outlined mr-2">power_settings_new</i>
                {{ __('Déconnexion') }}
            </a>

        </form>



    </div>
</div>
