<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NotificationController;

class Signout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sign:out';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $attendance_controller = app()->make(NotificationController::class);


        $usernoti_body = array(
            "title" => 'Sign Out Alert',
            "message" => "Don't forget to sign out before leaving!",
            "image" => "https://c7.alamy.com/comp/FRG7F5/sign-out-icon-with-white-on-red-background-FRG7F5.jpg",
        );
        $token =[];
        $employees = \DB::table('employees')->select('*')->where('status', '1')->get();

        foreach($employees as $employee){
            if($employee->fcm_token != '')
            {
                $token[] = $employee->fcm_token;
            }
           
        }
       

        $attendance_controller->send_notification($token, $usernoti_body);
        
        $this->info('Notification has been sent');
    }
}
