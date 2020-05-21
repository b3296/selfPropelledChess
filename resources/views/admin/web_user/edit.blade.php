@extends('layouts.app')

@section('title', '| Edit User')

@section('content')

    <div class='col-lg-4 col-lg-offset-4'>

        <h1><i class='fa fa-user-plus'></i> Edit {{$user->name}}</h1>
        <hr>

        {{ Form::model($user, array('route' => array('admin.web_user.update', $user->id), 'method' => 'PUT')) }}{{-- Form model binding to automatically populate our fields with user data --}}

        <input type="hidden" name="id" value="{{$user->id}}">
        <div class="form-group">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', $user->name, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('phone', 'Phone') }}
            <br>
            <input type="text" readonly="readonly" value="{{$user->phone}}">
        </div>

        <div class="form-group">
            {{ Form::label('strategy_num', 'strategy_num') }}
            {{ Form::text('strategy_num', $user->strategy_num, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('is_pass', '是否通过') }}
            <input type="radio" name="is_pass" value="1" {{$user->is_pass==1?'checked':''}}>是
            <input type="radio" name="is_pass" value="0" {{$user->is_pass==0?'checked':''}}>否
        </div>

        <div class="form-group">
            {{ Form::label('created_at', '注册时间') }}
            <br>
            <input type="text" readonly="readonly" value="{{$user->created_at}}">
        </div>




        {{ Form::submit('审核', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

    </div>

@endsection