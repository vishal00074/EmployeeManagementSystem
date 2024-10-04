<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MobileNotification;
use Validator, URL;

class NotificationController extends Controller
{
    public function Notification(Request $request)
    {

        return view('admin.notifications.add');
    }

    public function NotificationSend(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',
            'employee' => 'required',

        ]);
        $image = '';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/notification'), $imageName);
            $image = URL::to('/') . '/' . 'uploads/notification/' . $imageName;
        }

        $usernoti_body = array(
            "title" => $request->title,
            "message" => $request->message,
            "image" =>  $image,
        );
        
        $token = [];
        if ($request->employee == '0') {
            $employees = \DB::table('employees')->select('*')->where('status', '1')->get();
        } else {
            $employees = \DB::table('employees')->select('*')->where('id', $request->employee)->get();
        }


        foreach ($employees as $employee) {
            if ($employee->fcm_token != '') {
                $token[] = $employee->fcm_token;
            }
        }


        $this->send_notification($token, $usernoti_body);

        return redirect()->back()->with('success', 'Notification sent successfully');
    }




    public function sendFirebasePush($tokens, $usernoti_body)
    {

        $serverKey = env('FCM_SERVER_KEY');
        // prep the bundle
        $msg = array(
            'title'   => $usernoti_body['title'],
            'body' => $usernoti_body['message'],
            'image' => $usernoti_body['image'],
        );


        $notifyData = [
            'title'   => $usernoti_body['title'],
            'body' => $usernoti_body['message'],
            'image' => $usernoti_body['image'],
        ];



        $registrationIds = $tokens;




        if (count($tokens) > 1) {
            $fields = array(
                'registration_ids' => $registrationIds, //  for  multiple users
                'notification'  => $notifyData,
                'data' => $msg,
               
            );
        } else {
            $fields = array(
                'to' => $registrationIds[0], //  for  only one users
                'notification'  => $notifyData,
                'data' => $msg,
              
            );
        }


        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $serverKey;


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }








    public function APiNotification(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'device_id' => 'required',
                'fcm_token' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 200);
            }
            $input = $request->all();
            $is_exists = MobileNotification::where('device_id', $request->device_id)->first();
            if ($is_exists) {
                MobileNotification::where('device_id', $request->device_id)->update(['fcm_token' => $request->fcm_token]);
                return response()->json([
                    'status' => 'true',
                    'message' => 'success',
                ], 200);
            }
            MobileNotification::create($input);

            return response()->json([
                'status' => 'true',
                'message' => 'success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
        }
    }


    public function MobileNotify(Request $request)
    {
        return view('admin.notifications.mobile');
    }

    public function MobileNotificationSend(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',

        ]);
        $image = '';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/notification'), $imageName);
            $image = URL::to('/') . '/' . 'uploads/notification/' . $imageName;
        }

        $usernoti_body = array(
            "title" => $request->title,
            "message" => $request->message,
            'image' => $image
        );




        $tokens = [];
        $data =  MobileNotification::select('*')->get();


        foreach ($data as $item) {
            if ($item->fcm_token != '') {
                $tokens[] = $item->fcm_token;
            }
        }


        $this->send_notification($tokens, $usernoti_body);
        return redirect()->back()->with('success', 'Notification sent successfully');
    }

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
