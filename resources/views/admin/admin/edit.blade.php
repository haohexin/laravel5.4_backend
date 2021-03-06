@extends('admin.auth.main')
@section('content')
    <section class="content-header">
        <h1>
            <a class="btn bg-gray-active" href="{{url("/admin/admins")}}">管理员列表</a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url("/admin/index")}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">管理员管理</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @include('admin.others.alert')
        <div class="row">
            <!-- right column -->
            <div class="col-xs-12">
                <!-- general form elements disabled -->
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">修改管理员</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/admins/'.$data->id) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            <input type="hidden" name="id" value="{{ $data->id }}"/>
                            <input type="hidden" name="_method" value="PUT"/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">管理员类型</label>
                                <div class="col-sm-10">
                                    <select name="category" class="form-control input-sm">
                                        <option value="0">请选择</option>
                                        @foreach ($type as $value)
                                            <option value="{{$value->id}}" @if ($value->id == $data->roleId) selected @endif>
                                                {{$value->display_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">用户名</label>
                                <div class="col-sm-10">
                                    <input type="text" name="username" value="{{$data->account}}" class="form-control" placeholder="请输入用户名">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-10">
                                    <input type="text" name="password" class="form-control" placeholder="请输入密码">
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn bg-yellow-active pull-right">提交</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection