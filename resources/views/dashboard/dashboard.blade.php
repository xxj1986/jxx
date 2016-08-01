@extends('app')
<?php $menuCtl = ['dashboard'] ?>
@section('pageCss')
    <link rel="stylesheet" href="{{url('/lte/dist/css/skins/_all-skins.min.css')}}">
@endsection

@section('mainContents')
<section class="content">
        <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Title</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            Start creating your amazing application!
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            Footer
        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->
</section>
@endsection

@section('pageJs')
<script src="{{url('/lte/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{url('/lte/plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('/lte/dist/js/app.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('/lte/dist/js/demo.js')}}"></script>
@endsection
