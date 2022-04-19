<div id="head-bar-action-notif" class="head-bar-action-content-item" >
    <div class="content-item-titre  ">
        <h5 class="py-3">Notification</h5>
    </div>
    <div class="mt-2 overflow-auto" style="height: calc(100vh - 66px);height: calc(100vh - 66px);">
        @foreach ($notifications as $notification)
           <x-npl::util.head-bar-action.notif-item :type="$notification->type" 
                                              :titre="$notification->titre" 
                                              :message="$notification->message"
                                              :link="$notification->link"
                                              />
        @endforeach
    </div>

</div>