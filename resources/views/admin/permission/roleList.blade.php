@extends('admin.auth.main')
@section('content')
    <section class="content-header">
        <h1>
            <a class="btn bg-gray-active" href="{{url("/admin/roles")}}">角色列表</a>
            @if(Auth::guard('admin')->user()->can('roleAdd'))
                <a class="btn btn-linkedin" href="{{url("/admin/roles/create")}}">新增角色</a>
            @endif
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
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table id="example2" class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>角色</th>
                                <th>角色名称</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="part1">
                            @foreach ($data as $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->display_name }}</td>
                                    <td>
                                        @if(Auth::guard('admin')->user()->can('roleEdit'))
                                            <a href="{{url("/admin/roles/"."$value->id".'/edit')}}">
                                                <button class="btn bg-yellow-active pull-left margin-r-5">修改</button>
                                            </a>
                                        @endif
                                        @if(Auth::guard('admin')->user()->can('roleEditPermission'))
                                            <a href="{{url("/admin/roles/permissionEdit?id="."$value->id")}}">
                                                <button class="btn btn-facebook pull-left margin-r-5">修改权限</button>
                                            </a>
                                        @endif
                                        @if(Auth::guard('admin')->user()->can('roleDelete'))
                                            <button onclick="deleteIt('/admin/roles/delete?id={{$value->id}}')" class="btn btn-adn">删除
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="box-footer">
                            {!! $data->links() !!}
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
    <!-- DataTables -->
    <script src="{{url("/plugins/datatables/jquery.dataTables.min.js")}}"></script>
    <script src="{{url("/plugins/datatables/dataTables.bootstrap.min.js")}}"></script>
@endsection