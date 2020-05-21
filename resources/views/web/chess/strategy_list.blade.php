@extends('layouts.web')

@section('title', '| 策略列表')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-users"></i> 策略列表 <a href="{{ route('web.chess.piece.index') }}" class="btn btn-default pull-right">棋子</a>
            <a href="{{ route('web.chess.occupation.index') }}" class="btn btn-default pull-right">职业</a>
            <a href="{{ route('web.chess.race.index') }}" class="btn btn-default pull-right">种族</a>
        </h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                <thead>
                <tr>
                    <th>名称</th>
                    <th>描述</th>
                    <th>点赞量</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($strategys as $strategy)

                    <tr>
                       <td>{{$strategy->name}}</td>
                       <td>{{$strategy->description}}</td>
                       <td>{{$strategy->praise_num}}</td>
                       <td>{{$strategy->created_at}}</td>
                        <td style="width: 60px">
                            <a href="{{ route('web.chess.strategy.show', $strategy->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">查看</a>

                        </td>
                    </tr>
                @endforeach
                </tbody>


            </table>
        </div>
        {{ $strategys->links() }}

    </div>

@endsection