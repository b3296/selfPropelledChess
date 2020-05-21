@extends('layouts.web')

@section('title', '| 种族')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-key"></i> 种族

            <a  href="{{ route('web.chess.occupation.index') }}" class="btn btn-default pull-right">职业</a>
            <a  href="{{ route('web.chess.piece.index') }}" class="btn btn-default pull-right">棋子</a></h1>
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
                            <a href="{{ URL::to('web/race/'.$occupa->id.'/show') }}" class="btn btn-info pull-left" style="margin-right: 3px;">查看</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

    </div>

@endsection