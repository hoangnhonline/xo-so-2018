@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Nhân viên
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('staff.index') }}">Nhân viên</a></li>
      <li class="active">Cập nhật</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('staff.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('staff.update') }}">
      <input type="hidden" name="id" value="{{ $detail->id }}">
    <div class="row">
      <!-- left column -->

      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Cập nhật</h3>
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}

            <div class="box-body">
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif 
              <div class="row">
                <div class="form-group col-md-12">
                  <label>Tên ngắn<span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="short_name" id="short_name" value="{{ old('short_name', $detail->short_name) }}">
                </div>
                <div class="form-group col-md-12">
                  <label>Họ tên</label>
                  <input type="text" class="form-control" name="full_name" id="full_name" value="{{ old('full_name', $detail->full_name) }}">
                </div>
                <div class="form-group col-md-12">
                  <label>Điện thoại</label>
                  <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $detail->phone) }}">
                </div>              
                <div class="form-group col-md-12">
                  <label>Facebook</label>
                  <input type="text" class="form-control" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', $detail->facebook_url) }}">
                </div>              
                <div class="form-group col-md-12">
                     <label class="control-label">Bộ phận</label>                        
                     <div class="controls" style="padding-left: 20px">
                        <div class="clearfix"></div>
                        <label class="checkbox">
                                                            
                              <input style="opacity: 1" type="checkbox" {{ old('type', $detail->type) == 2 ? "checked=checked" : "" }} value="2" name="type" style="opacity: 0;"></span>
                          
                           Tiếp nhận                   
                        </label>
                        <div class="clearfix"></div>
                        <label class="checkbox">
                                                           
                              <input  style="opacity: 1" type="checkbox"  {{ old('type_1', $detail->type_1) == 1 ? "checked=checked" : "" }}  value="1" name="type_1" style="opacity: 0;"></span>
                           
                           May
                        </label>
                        <div class="clearfix"></div>
                        <label class="checkbox">
                                                               
                              <input  style="opacity: 1" type="checkbox"  {{ old('type_2', $detail->type_2) == 3 ? "checked=checked" : "" }}  value="3" name="type_2" style="opacity: 0;"></span>
                          
                           Đính kết
                        </label>
                     </div>
                  </div>
              </div>                             
            </div>              
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('staff.index')}}">Hủy</a>
            </div>
        </div>
        <!-- /.box -->     

      </div>
    
      <!--/.col (left) -->      
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@stop