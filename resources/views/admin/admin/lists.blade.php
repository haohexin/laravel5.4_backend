@extends('admin.auth.main')
@section('content')
    <section class="content-header">
        <h1>
            <a class="btn bg-gray-active" href="{{url("/admin/admins")}}">管理员列表</a>
            @if(Auth::guard('admin')->user()->can('adminAdd'))
                <a class="btn btn-linkedin" href="{{url("/admin/admins/create")}}">新增管理员</a>
            @endif
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
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table id="example2" class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>管理员类型</th>
                                <th>用户名</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="part1">
                            @foreach ($data as $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->roles?$value->roles[0]->display_name:'暂无'}}</td>
                                    <td>{{ $value->account }}</td>
                                    <td>
                                        @if(Auth::guard('admin')->user()->can('adminEdit'))
                                            <a href="{{url("/admin/admins/"."$value->id".'/edit')}}">
                                                <button class="btn bg-yellow-active pull-left margin-r-5">修改</button>
                                            </a>
                                        @endif
                                        @if(Auth::guard('admin')->user()->can('adminDelete') && $value->id != 1)
                                            <button onclick="deleteIt('/admin/admins/delete?id={{$value->id}}')" class="btn btn-adn">删除
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
@endsection