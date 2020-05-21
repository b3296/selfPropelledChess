@extends('layouts.app')

@section('title', '| 棋子')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-users"></i> 棋子 <a href="{{ route('occupation.index') }}" class="btn btn-default pull-right">职业</a>
            <a href="{{ route('race.index') }}" class="btn btn-default pull-right">种族</a></h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                <thead>
                <tr>
                    <th>名称</th>
                    <th>昵称</th>
                    <th>费用</th>
                    <th>技能描述</th>
                    <th>职业</th>
                    <th>种族</th>
                    <th>操作</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($pieces as $piece)
                    <tr>

                        <td>{{ $piece->name }}</td>
                        <td>{{ $piece->nick_name }}</td>
                        <td>{{ $piece->expend }}</td>
                        <td style="width: 300px">{{ $piece->skill_description }}</td>
                        <td>

                            @foreach ($piece->occupation as $occupation)
                                <a href="{{ route('occupation.show', $occupation->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">
                                    {{$occupation->name}}
                                </a>

                            @endforeach

                        </td>
                        <td>
                            @foreach ($piece->race as $race)
                                <a href="{{ route('occupation.show', $race->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">
                                    {{$race->name}}
                                </a>

                            @endforeach

                        </td>
                        <td style="width: 200px">
                            <a href="{{ route('piece.show', $piece->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">查看</a>
                            <a href="{{ route('piece.edit', $piece->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">修改</a>

                            {!! Form::open(['method' => 'DELETE', 'route' => ['piece.destroy', $piece->id] ]) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}

                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <a href="{{ route('piece.create') }}" class="btn btn-success">添加棋子</a>

    </div>

@endsection