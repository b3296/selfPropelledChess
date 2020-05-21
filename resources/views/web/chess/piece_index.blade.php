@extends('layouts.web')

@section('title', '| 棋子')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-users"></i> 棋子 <a href="{{ route('web.chess.occupation.index') }}" class="btn btn-default pull-right">职业</a>
            <a href="{{ route('web.chess.race.index') }}" class="btn btn-default pull-right">种族</a></h1>
        <hr>
        <div class="table-responsive">
            {{ Form::open( array('route' => array('web.chess.piece.strategy'),'method' => 'POST')) }}
            {{ Form::submit('查看羁绊效果', array('class' => 'btn btn-primary')) }}
            @if (isset($errors) && count($errors))
                <span class="help-block" style="color:red">
                                        <strong>{{  $errors }}</strong>
                                    </span>
            @endif
            <table class="table table-bordered table-striped">

                <thead>
                <tr>
                    <th>选择棋子</th>
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

                        <td>{{ Form::checkbox('pieces[]',  $piece->id ) }}</td>
                        <td>{{ $piece->name }}</td>
                        <td>{{ $piece->nick_name }}</td>
                        <td>{{ $piece->expend }}</td>
                        <td style="width: 450px">{{ $piece->skill_description }}</td>
                        <td>

                            @foreach ($piece->occupation as $occupation)
                                <a href="{{ route('web.chess.occupation.show', $occupation->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">
                                    {{$occupation->name}}
                                </a>

                            @endforeach

                        </td>
                        <td>
                            @foreach ($piece->race as $race)
                                <a href="{{ route('web.chess.race.show', $race->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">
                                    {{$race->name}}
                                </a>

                            @endforeach

                        </td>
                        <td style="width: 60px">
                            <a href="{{ route('web.chess.piece.show', $piece->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">查看</a>

                        </td>
                    </tr>
                @endforeach
                </tbody>


            </table>
            {{ Form::close() }}
        </div>


    </div>

@endsection