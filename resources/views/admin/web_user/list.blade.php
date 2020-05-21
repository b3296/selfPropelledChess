@extends('layouts.app')

@section('title', '| WebUsers')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-users"></i> 用户列表 </h1>
        <form align="right" action="{{route('admin.web_user.list')}}" method="get">
            <input type="text" name="name">
            <input type="submit" value="搜索" >
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Date/Time Added</th>
                    <th>Is Pass</th>
                    <th>Operations</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($users as $user)
                    <tr>

                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->created_at}}</td>
                        <td>{{ $user->is_pass==1?'Yes':'No' }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}
                        <td>
                            <a href="{{ route('admin.web_user.edit', $user->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>


                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>


    </div>

@endsection