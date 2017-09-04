@extends('admin.auth.main')
@section('content')
    <section class="content-header">
        <h1>
            <a class="btn bg-gray-active" href="{{url("/admin/nav")}}">导航列表</a>
            @if(Auth::guard('admin')->user()->can('navAdd'))
                <a class="btn btn-linkedin" href="{{url("/admin/nav/create")}}">新增导航</a>
            @endif
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url("/admin/index")}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">导航管理</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @include('admin.others.alert')
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <label>
                        <select class="form-control" onchange="change(this);">
                            <option value="0">请选择</option>
                            @foreach($data as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </label>
                    <label id="part2">

                    </label>
                    <div class="box-body table-responsive no-padding">
                        <table id="example2" class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>类型</th>
                                <th>URL</th>
                                <th>权限</th>
                                <th>图标</th>
                                <th>排序</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="part1">
                            @foreach ($data as $value)
                                <tr>
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->name?$value->name:'暂无'}}</td>
                                    <td>{{$value->url?$value->url:'暂无'}}</td>
                                    <td>{{$value->permission?$value->permission:'暂无'}}</td>
                                    <td>{{$value->icon?$value->icon:'暂无'}}</td>
                                    <td>{{$value->rank?$value->rank:'暂无'}}</td>
                                    <td>
                                        @if(Auth::guard('admin')->user()->can('navEdit'))
                                            <a href="{{url("/admin/nav/"."$value->id".'/edit')}}">
                                                <button class="btn bg-yellow-active pull-left margin-r-5">修改</button>
                                            </a>
                                        @endif
                                        @if(Auth::guard('admin')->user()->can('navDelete'))
                                            <button onclick="deleteIt('/admin/nav/delete?id={{$value->id}}')" class="btn btn-adn">删除
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            {{--{!! $data->links() !!}--}}
                        </table>
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


    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

        function change(a) {
            var id = a.value;
            $.ajax({
                type: "get", url: "<?php echo url('/admin/nav/findLists');?>", data: {
                    id: id
                }, cache: false, async: true, dataType: 'json',
                success: function (data) {
                    var aa = "";
                    $("#part1").empty();
                    $("#part2").empty();
                    if (id == 0) {
                        $.each(data, function (index, item) {
                            $("#part1").append(
                                "<tr><td>" + item.id + "</td>" +
                                "<td>" + item.code + "</td>" +
                                "<td>" + item.url + "</td>" +
                                "<td>" + item.permission + "</td>" +
                                "<td>" + item.icon + "</td>" +
                                "<td>" + item.rank + "</td>" +
                                "<td>" +
                                "<a href='{{url('/admin/nav')}}" + '/' + "" + item.id + "" + '/edit' + "'><button class='btn bg-yellow-active pull-left margin-r-5'>修改</button></a>" +
                                "<form method='post' action='{{url('/admin/nav/')}}'><input type='hidden' name='_token' value='{{ csrf_token() }}' /><input type='hidden' name='_method' value='DELETE'><button type='submit' class='btn btn-adn'>删除</button> </form>" +
                                "</td>" +
                                "</tr>"
                            );
                        });
                    } else {
                        $.each(data, function (index, item) {
                            $("#part1").append(
                                "<tr><td>" + item.id + "</td>" +
                                "<td>" + item.name + "</td>" +
                                "<td>" + item.url + "</td>" +
                                "<td>" + item.permission + "</td>" +
                                "<td>" + item.icon + "</td>" +
                                "<td>" + item.rank + "</td>" +
                                "<td>" +
                                "<a href='{{url('/admin/nav')}}" + '/' + "" + item.id + "" + '/edit' + "'><button class='btn bg-yellow-active pull-left margin-r-5'>修改</button></a>" +
                                "<form method='post' action='{{url('/admin/nav')}}" + '/' + "" + item.id + "'><input type='hidden' name='_token' value='{{ csrf_token() }}' /><input type='hidden' name='_method' value='DELETE'><button type='submit' class='btn btn-adn'>删除</button> </form>" +
                                "</td>" +
                                "</tr>"
                            );
                        });
                        $.each(data, function (index, item) {
                            aa += "<option value='" + item.id + "'>" + item.name + "</option>";
                        });
                    }
                }
            });
        }

        function change2(a) {
            var id = a.value;
            $.ajax({
                type: "get", url: "<?php echo url('/admin/address/find_lists');?>", data: {
                    id: id,
                    province: id
                }, cache: false, async: true, dataType: 'json',
                success: function (data) {
                    if (id == 0) {
                        $("#part1").empty();
                    } else {
                        $("#part1").empty();
                        $.each(data, function (index, item) {
                            $("#part1").append(
                                "<tr><td>" + item.id + "</td><td>" + item.code + "</td><td>" + item.name + "</td><td><a class='btn btn-bitbucket' href='{{url('/admin/address/edit?id=')}}" + item.id + "'>修改</a> <a class='btn btn-adn' href='{{url('/admin/address/destroy?id=')}}" + item.id + "'>删除</a></td></tr>"
                            );
                        });
                    }
                }
            });
        }
    </script>

@endsection