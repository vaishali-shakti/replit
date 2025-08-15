<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Messages;
use App\Models\Supporter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Mail;
use App\Mail\closeQueryMail;
use DB;
use Session;
class ChatController extends Controller
{
    public function index(Request $request){
        try{
            if(!Auth::user()->can('support-list')){
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }

            if($request->ajax()){
                $getSupport = Supporter::with(['getUser','latestMsg'])->whereHas('getUser')->select('*',DB::raw('1 as formated_created_at'))->get();
                $getSupport = $getSupport->map(function ($item) {
                    $created_at = \Carbon\Carbon::parse($item->latestMsg->created_at)->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s');
                    $item->formated_created_at = (string)$created_at;
                    return $item;
                });
                $getSupport = $getSupport->sortByDesc('formated_created_at')->values();

                return DataTables::of($getSupport)
                ->addColumn('formatted_created_at', function ($row) {
                    return $row->formated_created_at ? $row->formated_created_at : '';
                    // return $row->latestMsg->created_at ? convert_timezone($row->latestMsg->created_at) : '';
                })
                ->editColumn('name', function ($row) {
                    return $row->getUser ? $row->getUser->name : '';
                })
                ->editColumn('msg_status', function ($row){
                    return $row->msg_status;
                })
                ->addColumn('message_status', function ($row){
                    return $row->msg_status == 1 ? 'Closed' : 'Active';
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (Auth::user()->can('support-edit')) {
                        if($row->msg_status == 2){
                            $btn = '<a href="'.route('support.edit', $row->id).'" title="Reply To User"><svg fill="#32ad40" height="40px" width="40px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" stroke="#34bc43"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M385.045,0H126.955C56.96,0,0,56.96,0,126.976v130.048C0,327.04,56.96,384,126.955,384h80.832 c17.813,10.283,85.44,52.523,114.133,115.52c3.52,7.723,11.179,12.48,19.413,12.48c1.493,0,3.029-0.149,4.523-0.491 c9.813-2.133,16.811-10.795,16.811-20.843V384h22.379C455.04,384,512,327.04,512,257.024V126.976C512,56.96,455.04,0,385.045,0z M128,234.667c-23.573,0-42.667-19.093-42.667-42.667s19.093-42.667,42.667-42.667c23.573,0,42.667,19.093,42.667,42.667 S151.573,234.667,128,234.667z M256,234.667c-23.573,0-42.667-19.093-42.667-42.667s19.093-42.667,42.667-42.667 s42.667,19.093,42.667,42.667S279.573,234.667,256,234.667z M384,234.667c-23.573,0-42.667-19.093-42.667-42.667 s19.093-42.667,42.667-42.667c23.573,0,42.667,19.093,42.667,42.667S407.573,234.667,384,234.667z"></path> </g> </g> </g></svg></a>';
                        }else{
                            $btn = '<a href="'.route('support.edit', $row->id).'" title="View Closed Chat"><svg fill="#4bb8fb" height="40px" width="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#4b9eec"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M0 16q0.064 0.128 0.16 0.352t0.48 0.928 0.832 1.344 1.248 1.536 1.664 1.696 2.144 1.568 2.624 1.344 3.136 0.896 3.712 0.352 3.712-0.352 3.168-0.928 2.592-1.312 2.144-1.6 1.664-1.632 1.248-1.6 0.832-1.312 0.48-0.928l0.16-0.352q-0.032-0.128-0.16-0.352t-0.48-0.896-0.832-1.344-1.248-1.568-1.664-1.664-2.144-1.568-2.624-1.344-3.136-0.896-3.712-0.352-3.712 0.352-3.168 0.896-2.592 1.344-2.144 1.568-1.664 1.664-1.248 1.568-0.832 1.344-0.48 0.928zM10.016 16q0-2.464 1.728-4.224t4.256-1.76 4.256 1.76 1.76 4.224-1.76 4.256-4.256 1.76-4.256-1.76-1.728-4.256zM12 16q0 1.664 1.184 2.848t2.816 1.152 2.816-1.152 1.184-2.848-1.184-2.816-2.816-1.184-2.816 1.184l2.816 2.816h-4z"></path> </g></svg></a>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action','date','message_status'])
                ->make(true);
            }
            return view('admin.support.index');
        }catch(\Throwable $th){
            $data = array(
                'name' => 'ChatController',
                'module' => 'index',
                'description' => $th->getMessage(),
            );
            Log::create($data);
            return redirect()->back()->with('error',$th->getMessage());
        }
        
    }

    public function edit($id){
        try{
            if(!Auth::user()->can('support-edit')){
                return redirect()->route('admin.dashboard')->with('error','Unauthorized Access.');
            }
            $support = Supporter::find($id);
            if(!$support){
                return redirect()->route('support.index')->with('error','Support not found.');
            }
            $getMessage = Messages::where('support_id', $id)->whereHas('getUser')->get();
            if($getMessage != null){
                $admin = auth()->guard('web')->user()->id;
                Messages::where('action_by', '!=', $admin)->where('support_id', $id)->where('is_read', 0)->update(['is_read' => 1]);
            }
            return view('admin.support.edit',compact('getMessage','support'));
        }catch(\Throwable $th){
            $data = array(
                'name' => 'ChatController',
                'module' => 'edit',
                'description' => $th->getMessage(),
            );
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
        
    }
    public function send_message(Request $request){
        try{
            $request->validate([
                'message' => 'required',
            ]);
            if($request->message != null){
                if(isset($request->support_id)){
                    $support = Supporter::where('id', $request->support_id)->where('msg_status',2)->exists();
                    if(!$support){
                        return response()->json(['status' => 1,'msg' => 'This query is already closed. Please continue with another query.']);
                    }
                }
                $support = Supporter::where('user_id',$request->user_id)->where('msg_status',2)->first();
                if(!$support){
                    $ticket_no = 'TICKET' . str_pad(Supporter::max('id') + 1, 4, '0', STR_PAD_LEFT);
                    $supportData = Supporter::create([
                        'user_id' => $request->user_id,
                        'msg_status' => 2,
                        'ticket_no' => $ticket_no
                    ]);
                } else{
                    $supportData = $support;
                }
                $messageData = Messages::create([
                    'support_id' => $supportData->id,
                    'message' => $request->message,
                    'action_by' => $request->user_id,
                ]);
                $sent_time = convert_timezone($messageData->created_at);
                $message = Messages::where('support_id', $supportData->id)->orderBy('created_at','asc')->get();
                $html = view('front.support_msg_list',compact('message'))->render();
                return response()->json(['status' => 0,'msg_data' => $messageData,'html' => $html,'sent_time' => $sent_time]);
            }
        }catch (\Throwable $th) {
            $data = [
                'name' => 'ChatController',
                'module' => 'send_message',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function close_chat(Request $request,$slug = null){
        try{
            if($slug != null){
                Supporter::where('user_id',auth()->guard('auth')->user()->id)->where('msg_status',2)->update(['msg_status' => 1]);
            }
            $support = Supporter::where('user_id',auth()->guard('auth')->user()->id)->orderByRaw("FIELD(msg_status, 2, 1)")->orderBy('created_at','desc')->get();
            $html = view('front.ticket_list',compact('support'))->render();
            return response()->json(['status' => 0,'html' => $html]);
        }catch (\Throwable $th) {
            $data = [
                'name' => 'ChatController',
                'module' => 'close_chat',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function admin_send_messages(Request $request){
        try{
            $support = Supporter::where('id', $request->support_id)->where('msg_status',2)->exists();
            if(!$support){
                return response()->json(['status' => 1, 'msg' => 'This query is already closed. Please continue with another query.']);
            }
            $data = array(
                'support_id' => $request->support_id,
                'action_by' => $request->user_id,
                'message' => $request->message
            );
            $store_msg = Messages::create($data);
            $sent_time = convert_timezone($store_msg->created_at);
            return response()->json(['status' => 0 ,'msg_data' => $store_msg ,'sent_time' => $sent_time]);
        }catch(\Throwable $th){
            $data = [
                'name' => 'ChatController',
                'module' => 'admin_send_messages',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    public function update_ticket(Request $request){
        try{
            Supporter::where('user_id',auth()->guard('auth')->user()->id)->where('msg_status',2)->update(['msg_status' => 1]);
            $html = view('front.support_msg_list')->render();
            return response()->json(['status' => 0,'html' => $html]);
        }catch(\Throwable $th){
            $data = [
                'name' => 'ChatController',
                'module' => 'update_ticket',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function chat_message_list(Request $request){
        try{
            $support_data = Supporter::find($request->id);
            $message = Messages::whereHas('getUser')->where('support_id',$support_data->id)->orderBy('created_at','asc')->get();
            if($message != null){
                Messages::where('action_by', '!=', auth()->guard('auth')->user()->id)->where('support_id', $support_data->id)->where('is_read',0)->update(['is_read' => 1]);
            }
            $html = view('front.support_msg_list',compact('message','support_data'))->render();
            return response()->json(['status' => 0,'html' => $html]);
        }catch(\Throwable $th){
            $data = [
                'name' => 'ChatController',
                'module' => 'chat_message_list',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function admin_close_query(Request $request){
        try{
            $getSupport = Supporter::find($request->id);
            if($getSupport != null){
                $userData = $getSupport->getUser;
                Mail::to($userData->email)->send(new closeQueryMail($userData));
                Supporter::where('id',$request->id)->where('msg_status',2)->update(['msg_status' => 1]);
                Session::flash('success','Query closed and mail sent successfully.');
                return response()->json(['status' => 'success']);
            }
        }catch(\Throwable $th){
            $data = [
                'name' => 'ChatController',
                'module' => 'admin_close_query',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
