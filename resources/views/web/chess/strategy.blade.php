@extends('layouts.web')

@section('title', '| 棋子策略')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-key"></i> 棋子策略

        </h1>
        <hr>
        {{ Form::open( array('route' => array('web.chess.strategy.save'),'method' => 'POST')) }}
        <div style="margin:0 auto; text-align:center">
            <table class="table table-bordered table-striped">

                <tr >
                    @foreach($pieces as $key=>$piece)
                        {{ Form::hidden('pieces['.$key.']',  $piece->id,['type'=>"hidden"]) }}
                        <td><img src="{{env('APP_URL').'/'.$piece->url}}" style="margin-right: 3px;"></td>
                    @endforeach
                </tr>
                <tr>
                    @foreach($pieces as $piece)
                        <td>{{$piece->nick_name}}</td>
                    @endforeach
                </tr>
            </table>
            <hr>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th style="margin:0 auto; text-align:center">职业/种族</th>
                    <th style="margin:0 auto; text-align:center">羁绊描述</th>
                    <th style="margin:0 auto; text-align:center">棋子</th>
                </tr>
                </thead>

                <tbody>
                @foreach($fetters as $fetter)
                    <tr>
                        <td>{{ $fetter['occupation_name'] }}</td>
                        <td>{{ $fetter['description'] }}</td>
                        <td>
                            @foreach($fetter['pieces'] as $fetter_piece)
                                <span class="btn btn-info pull-left" style="margin-right: 3px;" >
                                    {{$fetter_piece}}
                                </span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
        <div class="form-group">
            {{ Form::label('name', '名称') }}
            <input id="name" type="text" class="form-control" name="name" required maxlength="20">
        </div>
        <div class="form-group">
            {{ Form::label('description', '介绍一下') }}
            <input id="description" type="text" class="form-control" name="description" maxlength="200">
        </div>
        {{ Form::submit('保存', array('class' => 'btn btn-primary')) }}
        {{ Form::close() }}
    </div>

@endsection