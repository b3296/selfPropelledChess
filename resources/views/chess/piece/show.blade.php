@extends('layouts.app')

@section('title', '| 棋子详情')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-key"></i> {{$piece->name}}详情
            <a  href="{{ route('occupation.index') }}" class="btn btn-default pull-right">职业</a>
            <a  href="{{ route('race.index') }}" class="btn btn-default pull-right">种族</a>
            </h1>
        <hr>

        <div style="margin:0 auto; text-align:center">
            <h4>昵称：<b>{{$piece->nick_name}}</b></h4>
            <h4>费用：<b>{{$piece->expend}}</b></h4>
            <h4>技能：<b>{{$piece->skill_description}}</b></h4>
            <h4><img src="{{env('APP_URL').'/'.$piece->url}}" style="margin-right: 3px;">

                    @foreach ($piece->occupation as $occupation)
                        <a href="{{ route('occupation.show', $occupation->id) }}" class="btn btn-info " style="margin-right: 3px;">
                            {{$occupation->name}}
                        </a>

                    @endforeach

                    @foreach ($piece->race as $race)
                        <a href="{{ route('occupation.show', $race->id) }}" class="btn btn-info " style="margin-right: 3px;">
                            {{$race->name}}
                        </a>

                    @endforeach

            </h4>
            <table class="table table-bordered table-striped">
                <thead>
                <tr >
                    <th style="margin:0 auto; text-align:center">攻击属性</th>
                    <th></th>
                    <th style="margin:0 auto; text-align:center">防御属性</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>攻击速度</td>
                        <td>{{ $piece->attack_speed }}</td>
                        <td>护甲</td>
                        <td>{{ $piece->armor }}</td>
                    </tr>
                    <tr>
                        <td>攻击力</td>
                        <td>{{ $piece->aggressivity }}</td>
                        <td>物理抗性</td>
                        <td>{{ $piece->physical_resistance }}</td>
                    </tr>
                    <tr>
                        <td>攻击距离</td>
                        <td>{{ $piece->attack_distance }}</td>
                        <td>魔法抗性</td>
                        <td>{{ $piece->magic_resistance }}</td>
                    </tr>
                    <tr>
                        <td>移动速度</td>
                        <td>{{ $piece->moving_speed }}</td>
                        <td>状态抗性</td>
                        <td>{{ $piece->state_resistance }}</td>
                    </tr>
                    <tr>
                        <td>技能增强</td>
                        <td>{{ $piece->skill_enhancement }}</td>
                        <td>避闪</td>
                        <td>{{ $piece->dodge }}</td>
                    </tr>
                    <tr>
                        <td>魔法恢复</td>
                        <td>{{ $piece->magic_recovery }}</td>
                        <td>生命恢复</td>
                        <td>{{ $piece->life_recovery }}</td>
                    </tr>
                </tbody>

            </table>
        </div>


    </div>

@endsection