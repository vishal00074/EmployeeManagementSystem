<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
trait NotificationTrait
{
    public function send_notification($tokens, $body)
    {

        $key = env('FCM_SERVER_KEY');

        // $key = env('FCM_SERVER_KEY_NOTIFY');

        $url = 'https://fcm.googleapis.com/fcm/send';


        $msg = array(
            "title" => $body['title'],
            "body" => $body['message'],
            "icon" => 'https://xpertidea.com/wp-content/uploads/2022/12/logo.png',
            "image" => $body['image'],
            "click_action" => 'https://xpertidea.com/wp-content/uploads/2022/12/logo.png',

        );

        $data = array(
            'title' => $body['title'],
            'body' => $body['message'],
            "image" =>$body['image'],
            'url' => 'https://xpertidea.com/wp-content/uploads/2022/12/logo.png',
            "icon" => 'https://xpertidea.com/wp-content/uploads/2022/12/logo.png',
            
        );

        $registrationIds = $tokens;

        $extraNotificationData = ["body" => $body];
        if (count($tokens) > 1) {
            $fields = [

                'registration_ids' => $registrationIds,
                'notification'  => $msg,
                'data' => $data,
                'priority' => 'high'

            ];
        } else {
            $fields = [

                'to' => $registrationIds[0],
                'notification'  => $msg,
                'data' => $data,
                'priority' => 'high'

            ];
        }

        $headers = [
            'Authorization: key=' . $key,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}