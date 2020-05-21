@extends('layouts.app')

@section('title', '| 文章列表')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-users"></i> 文章列表
        </h1>
        <form align="right" action="{{route('admin.blog.list')}}" method="get">
            <input type="text" name="keyword">
            <input type="submit" value="搜索" >
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                <thead>
                <tr>
                    <th>标题</th>
                    <th>作者</th>
                    <th>点赞量</th>
                    <th>是否通过</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($blogs as $blog)

                    <tr>
                       <td>{{$blog->title}}</td>
                       <td>{{$blog->name}}</td>
                       <td>{{$blog->praise_num}}</td>
                       <td>{{$blog->is_show==1?'Yes':'No'}}</td>
                       <td>{{$blog->created_at}}</td>
                        <td style="width: 60px">
                            <a href="{{ route('admin.blog.show', $blog->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">查看</a>

                        </td>
                    </tr>
                @endforeach
                </tbody>


            </table>
        </div>
        {{ $blogs->links() }}

    </div>

@endsection