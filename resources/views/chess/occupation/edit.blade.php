@extends('layouts.app')

@section('title', '| 修改职业')

@section('content')

    <div class='col-lg-4 col-lg-offset-4'>
        <h1><i class='fa fa-key'></i> 修改职业: {{$occupation->name}}</h1>
        <hr>

        {{ Form::model($occupation, array('route' => array('occupation.update', $occupation->id), 'method' => 'PUT')) }}

        <div class="form-group">
            {{ Form::label('name', '职业名称') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('name', '职业技能') }}
            {{ Form::text('fetters_description', null, array('class' => 'form-control')) }}
        </div>

        <h5><b>触发个数与效果:</b></h5>
        @foreach ($fetters as $key=>$fetter)

            {{ Form::label('name', '数量') }}{{ Form::label('name', '描述') }}
            {{ Form::text('fetters['.$key.'][num]', $fetter->num, array('class' => 'form-control')) }}
            {{ Form::text('fetters['.$key.'][description]', $fetter->description, array('class' => 'form-control')) }}

        @endforeach
        <br>
        {{ Form::submit('修改', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}
    </div>

@endsection