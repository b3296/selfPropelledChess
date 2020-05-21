<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-01
 * Time: 10:24
 */

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\LeaveMessage;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function list()
    {
        $messages = LeaveMessage::select('leave_message.id','content','web_users.name','leave_message.created_at','is_read')
            ->leftJoin('web_users','web_users.id','=','leave_message.user_id')
            ->where('is_show',1)
            ->orderBy('leave_message.created_at','desc')
            ->paginate(10);
        return view('web.leave.list',compact('messages'));
    }

    public function create()
    {
        return view('web.leave.create');
    }

    public function save(Request $request)
    {
        $this->validate($request,[
            'content'=>'required|string'
        ]);
        $content = $request->input('content');
        $user_id = session()->get('userInfo')['id'];
        LeaveMessage::create(compact('content','user_id'));
        return redirect()->route('web.leave.list')->with('flash_message',
            'leave successfully added.');
    }

    public function show($id)
    {
        $message = LeaveMessage::select('leave_message.id','content','web_users.name','leave_message.created_at','is_read','reply')
            ->leftJoin('web_users','web_users.id','=','leave_message.user_id')
            ->where('is_show',1)
            ->where('leave_message.id',$id)
            ->FirstOrFail($id);
        return view('web.leave.show',compact('message'));
    }

}