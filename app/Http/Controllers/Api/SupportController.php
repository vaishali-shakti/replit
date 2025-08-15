<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supporter;
use App\Models\Messages;
use App\Models\Log;
use Illuminate\Support\Facades\Validator;

class SupportController extends Controller
{
    public function raise_new_ticket(Request $request) {
        try{
            Supporter::where('user_id',auth()->guard('api')->user()->id)->where('msg_status',2)->update(['msg_status' => 1]);
            return successResponse('Ticket raised successfully.');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SupportController',
                'module' => 'raise_new_ticket',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }

    public function support_list() {
        try{
            $support = Supporter::where('user_id', auth()->guard('api')->user()->id)->orderByRaw("FIELD(msg_status, 2, 1)")->orderBy('created_at','desc')->get();
            return successResponse('Support list retrieved successfully.',  ['support' => $support]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SupportController',
                'module' => 'support_list',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }

    public function messages_list(Request $request) {
        try{
            $rules = [
                'id' => 'required|exists:supporter,id',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessage = $validator->errors()->first();
                return errorResponse($errorMessage, $validator->messages());
            }

            $support = Supporter::find($request->id);
            $message = Messages::whereHas('getUser')->where('support_id',$request->id)->orderBy('created_at','asc')->get();
            $message = $message->map(function ($msg) {
                $msg->created_at = convert_timezone($msg->created_at, auth()->guard('api')->user()->timezone ?? 'UTC');
                return $msg;
            });
            if($message != null){
                Messages::where('action_by', '!=', auth()->guard('api')->user()->id)->where('support_id', $request->id)->where('is_read',0)->update(['is_read' => 1]);
            }
            return successResponse('Messages list retrieved successfully.', ['messages' => $message, 'ticket_status' => $support->msg_status]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SupportController',
                'module' => 'messages_list',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }

    public function send_message(Request $request) {
        try{
            $rules = [
                'message' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessage = $validator->errors()->first();
                return errorResponse($errorMessage, $validator->messages());
            }

            if(isset($request->support_id) && $request->support_id != null && $request->support_id != '' && $request->support_id != "null"){
                $support = Supporter::where('id', $request->support_id)->where('msg_status',2)->exists();
                if(!$support){
                    return errorResponse("This query is already closed. Please continue with another query.");
                }
            }

            $support = Supporter::where('user_id',auth()->guard('api')->user()->id)->where('msg_status',2)->first();
            if(!$support){
                $ticket_no = 'TICKET' . str_pad(Supporter::max('id') + 1, 4, '0', STR_PAD_LEFT);
                $support = Supporter::create([
                    'user_id' => auth()->guard('api')->user()->id,
                    'msg_status' => 2,
                    'ticket_no' => $ticket_no
                ]);
            }
            $messageData = Messages::create([
                'support_id' => $support->id,
                'message' => $request->message,
                'action_by' => auth()->guard('api')->user()->id,
            ]);

            return successResponse('Message sent successfully.',['support_id' => $support->id]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SupportController',
                'module' => 'send_message',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }

    public function close_query(Request $request) {
        try{
            Supporter::where('user_id',auth()->guard('api')->user()->id)->where('msg_status',2)->update(['msg_status' => 1]);
            return successResponse('Ticket closed successfully.');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SupportController',
                'module' => 'close_query',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }
}
