@extends('layouts.app')

@section('title', '| 文章一览')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">

        <div style="margin:0 auto; text-align:center">
            <h1><i class="fa fa-key"></i> {{$blog->title}}

            </h1>
            <hr>
            <h4 align="right">作者：{{$blog->name}}|发表时间：{{$blog->created_at}}</h4>
            <div style="font-size: 22px">{{$blog->content}}</div>
            <input type="radio" {{$blog->is_show==1?'checked':''}} onclick="blog_is_show(1,'blog',{{$blog->id}})">通过
            <input type="radio" {{$blog->is_show==0?'checked':''}} onclick="blog_is_show(0,'blog',{{$blog->id}})">未通过
            <input type="radio" {{$blog->is_top==1?'checked':''}} onclick="blog_is_show(1,'top',{{$blog->id}})">置顶
            <input type="radio" {{$blog->is_top==0?'checked':''}} onclick="blog_is_show(0,'top',{{$blog->id}})">未置顶
        </div>

        <hr>
        <div align="left" style="font-size: 18px">


                @foreach($comments as $comment)
                    <div>
                        {{$comment->name}}
                        @if($comment->user_id==$blog->user_id)
                            (作者)
                        @endif
                        ：{{$comment->content}}({{$comment->created_at}})
                        <input type="radio" {{$comment->is_show==1?'checked':''}} onclick="blog_is_show(1,'comment',{{$comment->id}})">通过
                        <input type="radio" {{$comment->is_show==0?'checked':''}} onclick="blog_is_show(0,'comment',{{$comment->id}})">未通过

                    </div>
                    <hr>
                @endforeach
        </div>

    </div>
    <script>
        function blog_is_show(is_show_type,change_type,id) {
            if(window.confirm('确定更改展示状态？')){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "/admin/blog/update" ,
                    data: {is_show:is_show_type,type:change_type,id:id},
                    success: function (data) {
                        console.log(data);
                        if (data.code != 200) {
                            alert(data.msg);
                        }else{
                            window.location.reload();
                        }
                    },
                    error : function(data) {
                        console.log(data);
                        alert("网络异常！");
                    }
                });
                return true;
            }else{
                window.location.reload();
                return false;
            }

        }
    </script>

@endsection