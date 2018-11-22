@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Thêm sản phẩm vào ĐH : {{ $orderInfo->customer->name }} - {{ $orderInfo->customer->phone }} [{{$orderInfo->id}}] 
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('orders.index', $order_id) }}">Chi tiết đơn hàng</a></li>
      <li class="active">Thêm sản phẩm</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('orders-detail.index', $order_id) }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('orders-detail.store') }}">
    <div class="row">
      <!-- left column -->

      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Thêm sản phẩm</h3>
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
              <div class="col-md-4">
                <div class="form-group">
                    <label for="email">Loại sản phẩm <span class="red-star">*</span></label>
                    <select class="form-control select2" name="loai_id" id="loai_id">
                        <option value="">-- Chọn --</option>
                        @foreach( $loaiList as $loai )
                        <option value="{{ $loai->id }}"
                        {{ old('loai_id') == $loai->id ? "selected" : "" }}                           
                        >{{ $loai->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                  <label>Mã sản phẩm <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="product_code" id="product_code" value="{{ old('product_code') }}">
                </div>
                <div class="form-group">
                  <label>Giá <span class="red-star">*</span></label>
                  <input type="text" class="form-control number" name="price" id="price" value="{{ old('price') }}">
                </div> 
                <div class="form-group">
                  <label>Số lượng <span class="red-star">*</span></label>
                  <input type="text" class="form-control number" name="number_product" id="number_product" value="{{ old('number_product') }}">
                </div>           
                <div class="form-group">
                  <label>Thành tiền <span class="red-star">*</span></label>
                  <input type="text" class="form-control number" name="total_price" id="total_price" value="{{ old('total_price') }}">
                </div>    
                <div class="form-group">
                  <label>Ngày giao <span class="red-star">*</span></label>
                  <input type="text" class="form-control datepicker" name="ngay_giao" id="ngay_giao" value="{{ old('ngay_giao') }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <label for="email">Màu sắc</label>
                    <select class="form-control select2" name="mau_id" id="mau_id">
                        <option value="">-- Chọn --</option>
                        @foreach( $colorList as $loai )
                        <option value="{{ $loai->id }}"
                        {{ old('mau_id') == $loai->id ? "selected" : "" }}                           
                        >{{ $loai->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Kiểu dáng</label>
                    <select class="form-control select2" name="kieu_id" id="kieu_id">
                        <option value="">-- Chọn --</option>
                        @foreach( $kieuList as $loai )
                        <option value="{{ $loai->id }}"
                        {{ old('kieu_id') == $loai->id ? "selected" : "" }}                           
                        >{{ $loai->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Size</label>
                    <select class="form-control select2" name="size_id" id="size_id">
                        <option value="">-- Chọn --</option>
                        @foreach( $sizeList as $loai )
                        <option value="{{ $loai->id }}"
                        {{ old('size_id') == $loai->id ? "selected" : "" }}                           
                        >{{ $loai->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Form</label>
                    <select class="form-control select2" name="form_status_id" id="form_status_id">
                        <option value="">-- Chọn --</option>
                        @foreach( $formStatusList as $loai )
                        <option value="{{ $loai->id }}"
                        {{ old('form_status_id') == $loai->id ? "selected" : "" }}                           
                        >{{ $loai->value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Đã thử form</label>
                    <select class="form-control select2" name="form_ok_id" id="form_ok_id">
                        <option value="">-- Chọn --</option>
                        @foreach( $formOkList as $loai )
                        <option value="{{ $loai->id }}"
                        {{ old('form_ok_id') == $loai->id ? "selected" : "" }}                           
                        >{{ $loai->value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Trạng thái</label>
                    <select class="form-control select2" name="process" id="process">
                        <option value="1" {{ old('process') == 1 ? 'selected' : '' }}>Chưa làm</option>
                        <option value="2" {{ old('process') == 2 ? 'selected' : '' }}>Đang làm</option>                  
                        <option value="3" {{ old('process') == 3 ? 'selected' : '' }}>Làm xong</option>
                        <option value="4" {{ old('process') == 4 ? 'selected' : '' }}>Đã giao</option>   
                    </select>
                </div>                
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <label for="email">Người nhận</label>
                    <select class="form-control select2" name="nguoi_nhan" id="nguoi_nhan">
                        <option value="">-- Chọn --</option>
                        @foreach( $staffNhanArr as $staff )
                        <option value="{{ $staff->id }}"
                        {{ old('nguoi_nhan') == $staff->id ? "selected" : "" }}                           
                        >{{ $staff->short_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Rập</label>
                    <select class="form-control select2" name="staff_rap" id="staff_rap">
                        <option value="">-- Chọn --</option>
                        @foreach( $staffArr as $staff )
                        <option value="{{ $staff->id }}"
                        {{ old('staff_rap') == $staff->id ? "selected" : "" }}                           
                        >{{ $staff->short_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Cắt</label>
                    <select class="form-control select2" name="staff_cat" id="staff_cat">
                        <option value="">-- Chọn --</option>
                        @foreach( $staffArr as $staff )
                        <option value="{{ $staff->id }}"
                        {{ old('staff_cat') == $staff->id ? "selected" : "" }}                           
                        >{{ $staff->short_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">May</label>
                    <select class="form-control select2" name="staff_may" id="staff_may">
                        <option value="">-- Chọn --</option>
                        @foreach( $staffArr as $staff )
                        <option value="{{ $staff->id }}"
                        {{ old('staff_may') == $staff->id ? "selected" : "" }}                           
                        >{{ $staff->short_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Ren</label>
                    <select class="form-control select2" name="staff_ren" id="staff_ren">
                        <option value="">-- Chọn --</option>
                        @foreach( $staffDinhArr as $staff )
                        <option value="{{ $staff->id }}"
                        {{ old('staff_ren') == $staff->id ? "selected" : "" }}                           
                        >{{ $staff->short_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Cườm</label>
                    <select class="form-control select2" name="staff_cuom" id="staff_cuom">
                        <option value="">-- Chọn --</option>
                        @foreach( $staffDinhArr as $staff )
                        <option value="{{ $staff->id }}"
                        {{ old('staff_cuom') == $staff->id ? "selected" : "" }}                           
                        >{{ $staff->short_name }}</option>
                        @endforeach  
                    </select>
                </div>                
              </div>
              <div class="col-md-5">
                <div class="form-group" style="margin-top:10px;margin-bottom:10px">  
                  <label class="col-md-3 row">Hình</label>    
                  <div class="col-md-9">
                    <img id="thumbnail_image" src="{{ old('image_url') ? Helper::showImage(old('image_url')) : URL::asset('public/assets/dist/img/img.png') }}" class="img-thumbnail" width="150">
                    <button class="btn btn-default btn-sm btn btnSingleUpload" data-set="image_url" data-image="thumbnail_image" type="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload</button>

                  </div>
                  <div style="clear:both"></div>
                </div> 
              </div>
              <div class="col-md-7">
                <div class="form-group">
                  <label>Ghi chú</label>
                  <textarea class="form-control" name="notes" id="notes" rows="5">{{ old('notes') }}</textarea>
                </div>
              </div>                
            </div>
            <input type="hidden" name="order_id" value="{{ $order_id }}">
            <!-- /.box-body -->
            <input type="hidden" name="image_url" id="image_url" value="{{ old('image_url') }}"/> 
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('orders-detail.index', $order_id)}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      
     
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
@stop
@section('javascript_page')
<script type="text/javascript">


    $(document).ready(function(){     
      
      $('#name').change(function(){
         var name = $.trim( $(this).val() );
         if( name != '' && $('#slug').val() == ''){
            $.ajax({
              url: $('#route_get_slug').val(),
              type: "POST",
              async: false,      
              data: {
                str : name
              },              
              success: function (response) {
                if( response.str ){                  
                  $('#slug').val( response.str );
                }                
              },
              error: function(response){                             
                  var errors = response.responseJSON;
                  for (var key in errors) {
                    
                  }
                  //$('#btnLoading').hide();
                  //$('#btnSave').show();
              }
            });
         }
      });

    });
    
</script>
@stop
