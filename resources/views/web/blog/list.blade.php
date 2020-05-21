@extends('layouts.web')

@section('title', '| 文章列表')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-users"></i> 文章列表
        </h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                <thead>
                <tr>
                    <th>标题</th>
                    <th>作者</th>
                    <th>点赞量</th>
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
                       <td>{{$blog->created_at}}</td>
                        <td style="width: 60px">
                            <a href="{{ route('web.blog.show', $blog->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">查看</a>

                        </td>
                    </tr>
                @endforeach
                </tbody>


            </table>
            <a href="{{ route('web.blog.create') }}" class="btn btn-success">发表文章</a>
        </div>
        {{ $blogs->links() }}

    </div>

@endsection