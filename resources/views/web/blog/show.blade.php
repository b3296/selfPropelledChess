@extends('layouts.web')

@section('title', '| 文章一览')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">

        <div style="margin:0 auto; text-align:center">
            <h1><i class="fa fa-key"></i> {{$blog->title}}

            </h1>
            <hr>
            <h4 align="right">作者：{{$blog->name}}|发表时间：{{$blog->created_at}}</h4>
            <div style="font-size: 22px">{{$blog->content}}</div>
            @if($blog->is_praise==1)
                <span class="btn btn-primary btn-lg">已赞</span>
            @else
                <button id="praise"  class="btn btn-primary btn-lg">赞</button>
            @endif
        </div>

        <form class="form-horizontal" id="form" onsubmit="return false" action="##" method="post">
            <input type="hidden" name="blog_id" value="{{$blog->id}}">
            <textarea id="content" class="form-control" name="content"  required>
                                   </textarea>
            <input type="button" value="立即评论" onclick="comment()">
        </form>
        <hr>
        <div align="left" style="font-size: 18px">


                @foreach($comments as $comment)
                    <div>
                        {{$comment->name}}
                        @if($comment->user_id==$blog->user_id)
                            (作者)
                        @endif
                        ：{{$comment->content}}({{$comment->created_at}})
                    </div>
                    <hr>
                @endforeach
        </div>

    </div>
    <script>
        $('#praise').click(function(){
            var id = {!! $blog->id !!}
            $.ajax({
                type: 'POST',
                url: '/web/praise/do',
                data: { work_id : id,type:2 },
                dataType: 'json',
                success: function(data){
                    if(data.code!=200){
                        alert(data.msg);
                    }else{
                        window.location.reload();
                    }
                },
                error: function(xhr, type){
                    console.log(2)
                    console.log(xhr)
                    console.log(type)
                }
            });
        })
        function comment() {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/web/blog/comment" ,
                data: $('#form').serialize(),
                success: function (data) {
                    console.log(data);
                    if (data.code != 200) {
                        alert(data.msg);
                    }else{
                        window.location.reload();
                    }
                },
                error : function() {
                    alert("网络异常！");
                }
            });
        }
    </script>

@endsection