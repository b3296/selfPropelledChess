<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-01
 * Time: 16:31
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\LeaveMessage;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function list(Request $request)
    {
        $messages = LeaveMessage::select('leave_message.id','content','web_users.name','leave_message.created_at','is_read','is_show')
            ->leftJoin('web_users','web_users.id','=','leave_message.user_id')
            ->when(!is_null($request->name),function($query)use($request){
                return $query->where('web_users.name','like','%'.$request->name.'%');
            })
            ->orderBy('leave_message.created_at','desc')
            ->paginate(10);
        return view('admin.leave.list',compact('messages'));
    }

    public function show($id)
    {
        $message = LeaveMessage::select('leave_message.id','content','web_users.name','leave_message.created_at','is_read','reply','is_show')
            ->leftJoin('web_users','web_users.id','=','leave_message.user_id')
            ->where('leave_message.id',$id)
            ->FirstOrFail($id);
        return view('admin.leave.show',compact('message'));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'id'=>'required|integer',
            'is_show'=>'required|integer|in:0,1',
            'reply'=>'required|string|nullable',
        ]);
        $message = LeaveMessage::findOrFail($request->id);
        $message->is_show = $request->is_show;
        $message->reply = $request->reply;
        $message->is_read = 1;
        $message->save();
        return view('admin.leave.show',compact('message'));
    }
}