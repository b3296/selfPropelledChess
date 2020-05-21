@extends('layouts.app')

@section('title', '| 修改棋子')

@section('content')

    <div class='col-lg-4 col-lg-offset-4'>

        <h1><i class='fa fa-user-plus'></i> 修改 {{$piece->name}}</h1>
        <hr>

        {{ Form::model($piece, array('route' => array('piece.update', $piece->id), 'method' => 'PUT','files' => true)) }}{{-- Form model binding to automatically populate our fields with user data --}}

        <div class="form-group">
            {{ Form::label('name', '名称') }}
            {{ Form::text('name', $piece->name, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('nick_name', '昵称') }}
            {{ Form::text('nick_name', $piece->nick_name, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('expend', '费用') }}
            {{ Form::text('expend', $piece->expend, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('skill_description', '技能') }}
            {{ Form::text('skill_description', $piece->skill_description, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('attack_speed', '攻击速度') }}
            {{ Form::text('attack_speed', $piece->attack_speed, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('aggressivity', '攻击力') }}
            {{ Form::text('aggressivity', $piece->aggressivity, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('attack_distance', '攻击距离') }}
            {{ Form::text('attack_distance', $piece->attack_distance, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('moving_speed', '移动速度') }}
            {{ Form::text('moving_speed', $piece->moving_speed, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('skill_enhancement', '技能增强') }}
            {{ Form::text('skill_enhancement', $piece->skill_enhancement, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('magic_recovery', '魔法恢复') }}
            {{ Form::text('magic_recovery', $piece->magic_recovery, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('armor', '护甲') }}
            {{ Form::text('armor', $piece->armor, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('physical_resistance', '物理抗性') }}
            {{ Form::text('physical_resistance', $piece->physical_resistance, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('magic_resistance', '魔法抗性') }}
            {{ Form::text('magic_resistance', $piece->magic_resistance, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('state_resistance', '状态抗性') }}
            {{ Form::text('state_resistance', $piece->state_resistance, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('dodge', '避闪') }}
            {{ Form::text('dodge', $piece->dodge, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('life_recovery', '生命回复') }}
            {{ Form::text('life_recovery', $piece->life_recovery, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            <img src="{{env('APP_URL').'/'.$piece->url}}" class="btn btn-info pull-left" style="margin-right: 3px;"/>
        </div>
        <div class="form-group">
            {{ Form::label('url', '图片') }}
            {{ Form::file('image') }}
        </div>
        <div class='form-group'>
            @foreach ($occupation as $val)
                {{ Form::checkbox('occupation[]',  $val->id ) }}
                {{ Form::label($val->name, ucfirst($val->name)) }}<br>

            @endforeach
        </div>

        {{ Form::submit('修改', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

    </div>

@endsection