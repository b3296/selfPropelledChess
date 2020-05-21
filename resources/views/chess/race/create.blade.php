@extends('layouts.app')

@section('title', '| 添加种族')

@section('content')

    <div class='col-lg-4 col-lg-offset-4'>

        <h1><i class='fa fa-key'></i> 添加种族</h1>
        <hr>

        {{ Form::open(array('url' => 'chess/race','method'=>'post')) }}

        <div class="form-group">
            {{ Form::label('name', '名称') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('name', '种族技能') }}
            {{ Form::text('fetters_description', null, array('class' => 'form-control')) }}
        </div>

        <h5><b>触发个数与效果:</b></h5>

        <div class="form-group">
            {{ Form::label('name', '数量') }}{{ Form::label('name', '描述') }}
            {{ Form::text('fetters[0][num]', null, array('class' => 'form-control')) }}
            {{ Form::text('fetters[0][description]', null, array('class' => 'form-control')) }}
            {{ Form::label('name', '数量') }}{{ Form::label('name', '描述') }}
            {{ Form::text('fetters[1][num]', null, array('class' => 'form-control')) }}
            {{ Form::text('fetters[1][description]description', null, array('class' => 'form-control')) }}
            {{ Form::label('name', '数量') }}{{ Form::label('name', '描述') }}
            {{ Form::text('fetters[2][num]', null, array('class' => 'form-control')) }}
            {{ Form::text('fetters[2][description]', null, array('class' => 'form-control')) }}
        </div>

        {{ Form::submit('添加', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

    </div>

@endsection