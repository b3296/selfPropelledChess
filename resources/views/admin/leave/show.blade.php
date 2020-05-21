@extends('layouts.app')

@section('title', '| 留言详情')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">

        <div style="margin:0 auto; text-align:center">
            <h4 >用户：{{$message->name}}|创建时间：{{$message->created_at}}</h4>
            <hr>
            <div style="font-size: 26px">内容：{{$message->content}}</div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" action="{{route('admin.leave.update')}}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$message->id}}">
                <input type="radio"  {{$message->is_show==1?'checked':''}} name="is_show" value="1">通过
                <input type="radio"  {{$message->is_show==0?'checked':''}} name="is_show" value="0">未通过
                <textarea name="reply" class="form-control" >
                    {{$message->reply}}
                </textarea>
                <input type="submit" value="确认" class="btn btn-primary">
            </form>
        </div>

    </div>


@endsection