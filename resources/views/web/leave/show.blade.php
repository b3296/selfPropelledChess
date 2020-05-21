@extends('layouts.web')

@section('title', '| 留言详情')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">

        <div style="margin:0 auto; text-align:center">
            <h4 >用户：{{$message->name}}|创建时间：{{$message->created_at}}</h4>
            <hr>
            <div style="font-size: 26px">内容：{{$message->content}}</div>
            @if($message->reply!='')
                <hr>
                <div style="font-size: 26px">博主回复：{{$message->reply}}</div>
            @endif
        </div>


    </div>


@endsection