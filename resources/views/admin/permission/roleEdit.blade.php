@extends('admin.auth.main')
@section('content')
    <section class="content-header">
        <h1>
            <a class="btn bg-gray-active" href="{{url("/admin/roles")}}">角色列表</a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url("/admin/index")}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">权限管理</li>
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
                        <h3 class="box-title">修改角色</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/roles/'.$data->id) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            <input type="hidden" name="id" value="{{ $data->id }}"/>
                            <input type="hidden" name="_method" value="PUT"/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">角色</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" value="{{ $data->name }}" placeholder="请输入权限">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">角色名称</label>
                                <div class="col-sm-10">
                                    <input type="text" name="display_name" class="form-control" value="{{ $data->display_name }}"
                                           placeholder="请输入权限名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">角色介绍</label>
                                <div class="col-sm-10">
                                    <input type="text" name="description" class="form-control" value="{{ $data->description }}"
                                           placeholder="请输入权限介绍">
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
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection