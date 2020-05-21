@extends('layouts.web')

@section('title', '| 棋子策略')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-key"></i> 棋子策略

        </h1>
        <hr>
        <h3>
            {{$strategy->name}}

            @if($strategy->is_praise==1)
                <span class="btn btn-primary btn-lg">已赞</span>
            @else
                <button id="praise"  class="btn btn-primary btn-lg">赞</button>
            @endif
        </h3>
        <h4>{{$strategy->description}}</h4>
        <div style="margin:0 auto; text-align:center">
            <table class="table table-bordered table-striped">

                <tr >
                    @foreach($pieces as $piece)
                    <td><img src="{{env('APP_URL').'/'.$piece->url}}" style="margin-right: 3px;"></td>
                    @endforeach

                </tr>
                <tr>
                    @foreach($pieces as $piece)
                        <td>{{$piece->nick_name}}</td>
                    @endforeach
                </tr>
            </table>
            <hr>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th style="margin:0 auto; text-align:center">职业/种族</th>
                    <th style="margin:0 auto; text-align:center">羁绊描述</th>
                    <th style="margin:0 auto; text-align:center">棋子</th>
                </tr>
                </thead>

                <tbody>
                @foreach($fetters as $fetter)
                    <tr>
                        <td>{{ $fetter['occupation_name'] }}</td>
                        <td>{{ $fetter['description'] }}</td>
                        <td>
                            @foreach($fetter['pieces'] as $fetter_piece)
                                <span class="btn btn-info pull-left" style="margin-right: 3px;" >
                                    {{$fetter_piece}}
                                </span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

    </div>
    <script>
        $('#praise').click(function(){
            var id = {!! $strategy->id !!}
            $.ajax({
                type: 'POST',
                url: '/web/praise/do',
                data: { work_id : id,type:1 },
                dataType: 'json',
                success: function(data){
                    if(data.code!=200){
                        alert(data.msg);
                    }else{
                        window.location.reload();
                    }
                },
                error: function(xhr, type){
                    console.log(2)
                    console.log(xhr)
                    console.log(type)
                }
            });
        })
    </script>

@endsection