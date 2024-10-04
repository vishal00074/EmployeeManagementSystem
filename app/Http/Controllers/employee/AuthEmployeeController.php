<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class AuthEmployeeController extends Controller
{
    public function getLogin(){
        return view('employee.login');
    }
 
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'official_email' => 'required|email',
            'password' => 'required',
        ]);
        
        if(auth()->guard('employee')->attempt(['official_email' => $request->input('official_email'),  'password' => $request->input('password')])){
          
            $user = auth()->guard('employee')->user();
            if($user->status =='0'){
                auth()->guard('employee')->logout();
                return back()->with('error','Whoops! something went wrong');
            }
            
                return redirect()->route('employeeDashboard')->with('success','You are Logged in sucessfully.');
            
        }else {
            return back()->with('error','Whoops! invalid email and password.');
        }
    }
 
    public function employeeLogout(Request $request)
    {
        auth()->guard('employee')->user()->update(['fcm_token'=>'']);
        auth()->guard('employee')->logout();
        // Session::flush();
       
        Session::put('success', 'You are logout sucessfully');
        return redirect(route('employeeLogin'));
    }
    
    public function updateToken(Request $request){
    try{
       
        auth()->guard('employee')->user()->update(['fcm_token'=>$request->token]);
        return response()->json([
            'success'=>true
        ]);
    }catch(\Exception $e){
        report($e);
        return response()->json([
            'success'=>false
        ],500);
    }
}
}
