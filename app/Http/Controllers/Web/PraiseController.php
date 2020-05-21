<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-03-28
 * Time: 16:17
 */

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Praise;
use App\Models\Strategy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PraiseController extends Controller
{
    public function doPraise(Request $request)
    {
        $validateor = Validator::make($request->all(),[
            'work_id'=>['required','integer','min:0'],
            'type'=>['required','integer','in:1,2']
        ]);
        if($validateor->fails()){
            return $this->err(202,$validateor->errors());
        }
        $type = $request->input('type');
        $work_id = $request->input('work_id');
        switch ($type)
        {
            case 1:
                $work = Strategy::findOrFail($work_id);
                break;
            case 2:
                $work = Blog::findOrFail($work_id);
                break;
        }
        $user_id = session()->get('userInfo')['id'];
        $is_praise = Praise::where('user_id',$user_id)->where('work_id',$work_id)->where('type',$type)->first();
        if($is_praise){
            return ['code'=>202,'msg'=>'已点赞'];
        }
        Praise::create(compact('work_id','type','user_id'));
        $work->increment('praise_num');
        return ['code'=>200,'msg'=>'success'];
    }
}