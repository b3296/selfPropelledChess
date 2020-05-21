<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-01
 * Time: 15:17
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function list(Request $request)
    {
        $blogs = Blog::select('blogs.id','title','content','blogs.created_at','praise_num','web_users.name','is_show')
            ->leftJoin('web_users','web_users.id','=','blogs.user_id')
            ->when(!is_null($request->input('keyword')),function($query)use($request){
                return $query->where('blogs.title','like','%'.$request->input('keyword').'%')
                    ->orWhere('web_users.name','like','%'.$request->input('keyword').'%');
            })
            ->orderBy('is_top','desc')
            ->orderBy('praise_num','desc')
            ->orderBy('created_at','desc')
            ->paginate(10);
        return view('admin.blog.list',compact('blogs'));
    }
    public function show($id)
    {
        $blog = Blog::select('blogs.id','title','content','user_id','blogs.created_at','praise_num','web_users.name','is_show','is_top')
            ->leftJoin('web_users','web_users.id','=','blogs.user_id')
            ->where('blogs.id',$id)
            ->firstOrFail();
        $comments = Comment::select('comments.id','user_id','content','comments.created_at','web_users.name','is_show')
            ->leftJoin('web_users','web_users.id','=','comments.user_id')
            ->where('blog_id',$id)
            ->orderBy('created_at','desc')
            ->get();
        return view('admin.blog.show',compact('blog','comments'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'is_show'=>['required','integer','in:0,1'],
            'type'=>['required','string','in:blog,comment,top'],
            'id'=>['required','string']
        ]);
        if($validator->fails()){
            return ['code'=>202,'msg'=>'param error'];
        }
        $type = $request->type;
        $is_show = $request->is_show;
        $id = $request->id;
        switch ($type){
            case 'blog':
                $model = Blog::findOrFail($id);
                $model->is_show = $is_show;
                break;
            case 'comment':
                $model = Comment::findOrFail($id);
                $model->is_show = $is_show;
                break;
            case 'top':
                $model = Blog::findOrFail($id);
                $model->is_top = $is_show;
                break;
        }
        $model->save();
        return ['code'=>200,'msg'=>'success'];
    }
}