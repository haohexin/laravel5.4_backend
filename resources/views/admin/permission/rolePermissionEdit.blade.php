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
                        <h3 class="box-title">修改角色权限</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <label>角色名</label>
                            <input type="text" name="display_name" value="{{$role->display_name}}" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>角色</label>
                            <input type="text" name="hospital" value="{{$role->name}}" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>权限:</label>
                            <button type="button" class="btn-box-tool" onclick="chooseAll()">全选</button>
                            <button type="button" class="btn-box-tool" onclick="chooseNone()">全不选</button>
                        </div>
                        <form role="form" method="POST" action="{{ url('admin/roles/permissionEditPost') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            <input type="hidden" name="id" value="{{$role->id}}"/>
                            @foreach ($data as $value)
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="ids[]" value="{{$value->id}}" class="icheckbox_flat-blue"
                                               @if(in_array($value->id,$yan)) checked @endif>{{$value->display_name}}-{{$value->name}}
                                    </label>
                                </div>
                            @endforeach
                            <div class="box-footer">
                                <button type="submit" class="btn bg-yellow-active btn-right">提交</button>
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
    <script>
        function chooseAll() {
            var ch = document.getElementsByName("ids[]");
            for (var i = 0; i < ch.length; i++) {
                ch[i].checked = true;
            }
        }

        function chooseNone() {
            var ch = document.getElementsByName("ids[]");
            for (var i = 0; i < ch.length; i++) {
                ch[i].checked = false;
            }
        }
    </script>
@endsection