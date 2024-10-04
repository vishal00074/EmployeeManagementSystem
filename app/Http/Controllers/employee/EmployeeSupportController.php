<?php

namespace App\Http\Controllers\employee;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Auth;
use App\Models\Support;
use App\Models\SupportMessage;

use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Support\Facades\Storage;


class EmployeeSupportController extends Controller
{
    public function Support(Request $request)
     {

        $employee = Auth::guard('employee')->user();

        $support = Support::where('employee_id', $employee->id)->get();

       

        // Check if any tasks are found
        if ($support->isNotEmpty()) {
            return view('employee.support', compact('support'));
        } else {
            // No tasks found, pass empty tasks collection
            $support = collect();
            return view('employee.support', compact('support'));
        }


         return view('employee.support', compact('support'));
     }


     public function MessagesSupport(Request $request, $id)
        {
            $supportDetails = SupportMessage::where('support_id', $id)
                                            ->orderBy('created_at', 'ASC')
                                            ->get();
            return view('employee.support_messages', compact('supportDetails'));
        }



     public function AddSupport(Request $request)
      {
        $employee = Auth::guard('employee')->user();
        
        $request->validate([
            'subject' => 'required',
            'description' => 'required',
        ]);

        $input = $request->all();
        $input['employee_id'] = $employee->id; 

        unset($input['_token']);

        Support::create($input);

        return redirect()->back()->with('success', 'Ticket has been Generated');
     }

       public function AddSupportMessage(Request $request)

        {
            // dd($request);

             // $employee = Auth::guard('employee')->user();
            
              $request->validate([
                'message' => 'required',
              ]);   
       
            $input = $request->all();

            unset($input['_token']);
 
            SupportMessage::create($input);

            return redirect()->back()->with('success', 'Message has been Generated');
       }

      public function delete($id) {
             // dd($id);
            $post = Support::find($id);

            if (!$post) {
                return redirect()->back()->with('error', 'Post not found.');
            }
 
            try {
                $post->delete();
                return redirect()->back()->with('success', 'Post deleted successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to delete post.');
            }
}

      public function deleteMessage($id) {
             // dd($id);
            $post = SupportMessage::find($id);

            if (!$post) {
                return redirect()->back()->with('error', 'Post not found.');
            }
 
            try {
                $post->delete();
                return redirect()->back()->with('success', 'Message deleted successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to delete Message.');
            }
      }



// public function update(Request $request)
//     {
//         // Validate the request data if needed
//         $request->validate([
           
//             'message' => 'required|string',
//         ]);

//         // Find the support message by its ID
//         $message = SupportMessage::findOrFail($request->message_id);

//         // Update the message content
//         $message->message = $request->message;
//         $message->save();

//         // You can return a response if needed, such as a success message
//         return response()->json(['success' => true, 'message' => 'Message updated successfully']);
//     }


     
   
}
