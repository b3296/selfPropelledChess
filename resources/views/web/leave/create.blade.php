@extends('layouts.web')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">创建留言</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('web.leave.save') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">内容</label>

                                <div class="col-md-6">
                                    <textarea id="content" class="form-control" name="content" value="{{ old('content') }}" required>
                                    </textarea>
                                    @if ($errors->has('content'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        创建
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
