<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-03-28
 * Time: 17:27
 */

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Praise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function create()
    {
        return view('web.blog.create');
    }
    public function save(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|string|max:50',
            'content'=>'required|string'
        ]);
        $title = $request->input('title');
        $content = $request->input('content');
        $user_id = session()->get('userInfo')['id'];
        Blog::create(compact('title','content','user_id'));
        return redirect()->route('web.blog.list')->with('flash_message',
            'blog successfully added.');
    }
    public function list()
    {
        $blogs = Blog::select('blogs.id','title','content','blogs.created_at','praise_num','web_users.name')
            ->leftJoin('web_users','web_users.id','=','blogs.user_id')
            ->where('is_show',1)
            ->orderBy('is_top','desc')
            ->orderBy('praise_num','desc')
            ->orderBy('created_at','desc')
            ->paginate(10);
        return view('web.blog.list',compact('blogs'));
    }
    public function show($id)
    {
        $blog = Blog::select('blogs.id','title','content','user_id','blogs.created_at','praise_num','web_users.name')
            ->leftJoin('web_users','web_users.id','=','blogs.user_id')
            ->where('blogs.id',$id)
            ->where('is_show',1)
            ->firstOrFail();
        $is_praise = 0;
        if(session()->exists('userInfo')){
            $user_id = session()->get('userInfo')['id'];
            $praise = Praise::where('user_id',$user_id)->where('work_id',$id)->where('type',2)->first();
            if($praise){
                $is_praise = 1;
            }
        }
        $blog->is_praise = $is_praise;
        $comments = Comment::select('user_id','content','comments.created_at','web_users.name')
            ->leftJoin('web_users','web_users.id','=','comments.user_id')
            ->where('blog_id',$id)
            ->where('is_show',1)
            ->orderBy('created_at','desc')
            ->get();
        return view('web.blog.show',compact('blog','comments'));
    }
    public function comment(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'content'=>['required','string'],
            'blog_id'=>['required','integer','min:0']
        ]);
        if($validator->fails()){
            return ['code'=>202,'msg'=>'请填写评论内容'];
        }
        $content = $request->input('content');
        $blog_id = $request->input('blog_id');
        $user_id = session()->get('userInfo')['id'];
        Comment::create(compact('content','blog_id','user_id'));
        return ['code'=>200,'msg'=>'success'];
    }
}