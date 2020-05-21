@extends('layouts.app')

@section('title', '| 职业')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-key"></i> 职业

            <a  href="{{ route('race.index') }}" class="btn btn-default pull-right">种族</a>
            <a  href="{{ route('piece.index') }}" class="btn btn-default pull-right">棋子</a></h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>职业</th>
                    <th>技能</th>
                    <th>操作</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($occupation as $occupa)
                    <tr>

                        <td>{{ $occupa->name }}</td>
                        <td>{{ $occupa->fetters_description }}</td>
                        <td>
                            <a href="{{ URL::to('chess/occupation/'.$occupa->id.'/show') }}" class="btn btn-info pull-left" style="margin-right: 3px;">查看</a>

                            <a href="{{ URL::to('chess/occupation/'.$occupa->id.'/edit') }}" class="btn btn-info pull-left" style="margin-right: 3px;">修改</a>

                            {!! Form::open(['method' => 'DELETE', 'route' => ['occupation.destroy', $occupa->id] ]) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}

                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <a href="{{ URL::to('chess/occupation/create') }}" class="btn btn-success">添加职业</a>

    </div>

@endsection