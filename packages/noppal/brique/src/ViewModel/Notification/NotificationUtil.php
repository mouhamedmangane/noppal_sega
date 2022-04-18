<?php

namespace Npl\Brique\ViewModel\Notification;

class NotificationUtil {
    // pour material design
    static $notFoundIcon = "notifications";
    static $typeIcons = [
        "important"=> "notifications_important",
        "info"=> "info",
        "attention" => "warning"
    ];

    public static   function getIcon($typeNotification){
        if(isset(self::$typeIcons[$typeNotification]))
            return self::$typeIcons[$typeNotification];
        else
            return self::$notFoundIcon;
    }


}