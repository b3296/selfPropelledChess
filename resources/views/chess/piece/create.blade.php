@extends('layouts.app')

@section('title', '| 添加棋子')

@section('content')

    <div class='col-lg-4 col-lg-offset-4'>

        <h1><i class='fa fa-user-plus'></i> 添加棋子</h1>
        <hr>

        {{ Form::open(array('url' => 'chess/piece','files' => true)) }}

        <div class="form-group">
            {{ Form::label('name', '名称') }}
            {{ Form::text('name', '', array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('nick_name', '昵称') }}
            {{ Form::text('nick_name', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('expend', '费用') }}
            {{ Form::text('expend', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('skill_description', '技能') }}
            {{ Form::text('skill_description', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('attack_speed', '攻击速度') }}
            {{ Form::text('attack_speed', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('aggressivity', '攻击力') }}
            {{ Form::text('aggressivity', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('attack_distance', '攻击距离') }}
            {{ Form::text('attack_distance', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('moving_speed', '移动速度') }}
            {{ Form::text('moving_speed', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('skill_enhancement', '技能增强') }}
            {{ Form::text('skill_enhancement', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('magic_recovery', '魔法恢复') }}
            {{ Form::text('magic_recovery', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('armor', '护甲') }}
            {{ Form::text('armor', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('physical_resistance', '物理抗性') }}
            {{ Form::text('physical_resistance', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('magic_resistance', '魔法抗性') }}
            {{ Form::text('magic_resistance', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('state_resistance', '状态抗性') }}
            {{ Form::text('state_resistance', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('dodge', '避闪') }}
            {{ Form::text('dodge', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('life_recovery', '生命回复') }}
            {{ Form::text('life_recovery', '', array('class' => 'form-control')) }}
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


        {{ Form::submit('添加', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

    </div>

@endsection