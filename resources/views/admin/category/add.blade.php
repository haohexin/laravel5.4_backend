@extends('admin.auth.main')
@section('content')
    <section class="content-header">
        <h1>
            <a class="btn bg-gray-active" href="{{url("/admin/category")}}">类型列表</a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url("/admin/index")}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">类型管理</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @include('admin.others.alert')
        <div class="row">
            <!-- right column -->
            <div class="col-xs-12">
                <!-- general form elements disabled -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">新增类型</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/category') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">级别</label>
                                <div class="col-sm-10">
                                    <select name="type" class="form-control input-sm" onchange="change(this);">
                                        <option value="1">一级</option>
                                        <option value="2">二级</option>
                                        <option value="3">三级</option>
                                    </select>
                                </div>
                            </div>
                            <div id="part1"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">名称</label>
                                <div class="col-sm-10">
                                    <input type="text" name="title" class="form-control" placeholder="多条数据用,分开">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">简介</label>
                                <div class="col-sm-10">
                                    <input type="text" name="intro" class="form-control" placeholder="多条数据用,分开">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">排序</label>
                                <div class="col-sm-10">
                                    <input type="text" name="rank" class="form-control" placeholder="多条数据用,分开">
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-linkedin pull-right">提交</button>
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

    <script>
        function change(a) {
            var id = a.value;
            $("#part1").empty();
            if (id == 2) {
                $.ajax({
                    type: "get", url: "<?php echo url('/admin/category/findLists');?>", data: {
                        id: 0
                    }, cache: false, async: true, dataType: 'json',
                    success: function (data) {
                        var aa = "";
                        $.each(data, function (index, item) {
                            aa += "<option value='" + item.id + "'>" + item.name + "</option>";
                        });
                        $("#part1").append(
                            "<div class='form-group'>" +
                            "   <label class='col-sm-2 control-label'>选择父类型</label>" +
                            "       <div class='col-sm-10'>" +
                            "           <select name='province' class='form-control'>" +
                            "               <option value='0'>请选择</option>" + aa + "</select></div></div>"
                        );
                    }
                });
            } else if (id == 3) {
                $.ajax({
                    type: "get", url: "<?php echo url('/admin/category/findLists');?>", data: {
                        id: 0
                    }, cache: false, async: true, dataType: 'json',
                    success: function (data) {
                        var aa = "";
                        $.each(data, function (index, item) {
                            aa += "<option value='" + item.id + "'>" + item.name + "</option>";
                        });
                        $("#part1").append(
                            " <div class='form-group'>" +
                            "   <label class='col-sm-2 control-label'>选择父类型</label>" +
                            "       <div class='col-sm-10' >" +
                            "           <select name='province' class='form-control' onchange='change2(this);'>" +
                            "               <option value='0'>请选择</option>" + aa + "</select></div></div>" +
                            "<div class='form-group'>" +
                            "   <label class='col-sm-2 control-label'>选择二级类型</label>" +
                            "       <div class='col-sm-10' >" +
                            "           <select name='city' class='form-control' id='part2'>" +
                            "               <option value='0'>请选择</option></select></div></div>"
                        );
                    }
                });
            }

        }

        function change2(a) {
            var id = a.value;
            $.ajax({
                type: "get", url: "<?php echo url('/admin/category/findLists');?>", data: {
                    id: id
                }, cache: false, async: true, dataType: 'json',
                success: function (data) {
                    $("#part2").empty();
                    $.each(data, function (index, item) {
                        $("#part2").append(
                            "<option value='" + item.id + "'>" + item.name + "</option>"
                        );
                    });
                }
            });
        }
    </script>
@endsection