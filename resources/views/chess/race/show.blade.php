@extends('layouts.app')

@section('title', '| 种族详情')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-key"></i> {{$occupation->name}}详情

            <a  href="{{ route('occupation.index') }}" class="btn btn-default pull-right">职业</a>
            <a  href="{{ route('piece.index') }}" class="btn btn-default pull-right">棋子</a></h1>
        <h3><i class="fa fa-key"></i> 种族技能：{{$occupation->fetters_description}} </h3>
        <hr>
        <h4><b>触发个数与效果:</b></h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>数量</th>
                    <th>羁绊描述</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($fetters as $fetter)
                    <tr>

                        <td>{{ $fetter->num }}</td>
                        <td>{{ $fetter->description }}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
        <hr>
        <h4><b>棋子（{{count($pieces)}}）</b></h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>名称</th>
                    <th>费用</th>
                    <th style="width: 800px">技能描述</th>
                    <th>图片</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($pieces as $piece)
                    <tr>
                        <td><a href="{{ route('piece.show', $piece->id) }}">{{ $piece->name }}</a></td>
                        <td>{{ $piece->expend }}</td>
                        <td>{{ $piece->skill_description }}</td>
                        <td>
                            <a href="{{ route('piece.show', $piece->id) }}">
                                <img src="{{ env('APP_URL').'/'.$piece->url }}" style="margin-right: 3px;">
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>


    </div>

@endsection