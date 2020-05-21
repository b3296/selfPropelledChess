@extends('layouts.app')

@section('title', '| 留言列表')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-users"></i> 留言列表
        </h1>
        <form align="right" action="{{route('admin.leave.list')}}" method="get">
            <input type="text" name="name">
            <input type="submit" value="搜索" >
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                <thead>
                <tr>
                    <th>用户</th>
                    <th>内容</th>
                    <th>博主是否已读</th>
                    <th>是否通过</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($messages as $message)

                    <tr>
                       <td>{{$message->name}}</td>
                       <td style="width: 400px">{{mb_strlen($message->content,"utf-8")>25?mb_substr( $message->content, 0, 25, 'utf-8' ).'...':$message->content}}</td>
                       <td>{{$message->is_read==1?'是':'否'}}</td>
                       <td>{{$message->is_show==1?'是':'否'}}</td>
                       <td>{{$message->created_at}}</td>
                        <td style="width: 60px">
                            <a href="{{ route('admin.leave.show', $message->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">查看</a>

                        </td>
                    </tr>
                @endforeach
                </tbody>


            </table>
        </div>
        {{ $messages->links() }}

    </div>

@endsection