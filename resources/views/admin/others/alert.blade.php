<script src="/AdminLTE/sweetalert/sweetalert.min.js"></script>
@if (session('error'))
    <input id="alertContent" type="hidden" name="alertContent" value="{{session('error')}}">
    <script>
        var content = document.getElementById("alertContent").value;
        swal(content, "", "error");
    </script>
@elseif(session('success'))
    <input id="alertContent" type="hidden" name="alertContent" value="{{session('success')}}">
    <script>
        var content = document.getElementById("alertContent").value;
        swal(content, "", "success");
    </script>
@endif
@if (count($errors) > 0)
    <div id="modal" class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!!  implode('<br>', $errors->all()) !!}
    </div>
@endif
<script>
    setTimeout(function () {
        $("#modal").show().delay(1000).fadeOut();
    }, 1000);

    function deleteIt(url) {
        var url = url;
        swal({
                title: "确认删除?",
                text: "该项目将从列表中删除!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location.href = url;
                }
            });
    }
</script>
