@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Đơn hàng      
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('orders.index') }}">Đơn hàng</a></li>
      <li class="active">Cập nhật</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @if($backUrl)
    <a class="btn btn-default btn-sm" href="{{ $backUrl }}" style="margin-bottom:5px">Quay lại</a>
    @else
    <a class="btn btn-default btn-sm" href="{{ route('orders.index') }}" style="margin-bottom:5px">Quay lại</a>
    @endif
    <form role="form" method="POST" action="{{ route('orders.update') }}">
      <input type="hidden" name="id" value="{{ $detail->id }}">
      <input type="hidden" name="backUrl" value="{{ $backUrl }}">
    <div class="row">
      <!-- left column -->

      <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Cập nhật</h3>
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}

            <div class="box-body">
              @if(Session::has('message'))
              <p class="alert alert-info" >{{ Session::get('message') }}</p>
              @endif
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif               
                <div class="form-group">
                    <label for="email">Khách hàng <span class="red-star">*</span></label>
                    <select class="form-control select2" name="customer_id" id="customer_id">
                        <option value="">-- Chọn --</option>
                        @foreach( $customerList as $customer )
                        <option value="{{ $customer->id }}"
                        {{ old('customer_id', $detail->customer_id) == $customer->id ? "selected" : "" }}                           
                        >{{ $customer->name }} - {{ $customer->phone }}</option>
                        @endforeach
                    </select>
                </div>
                 <!-- text input -->
                <div class="row">
                <div class="form-group col-md-6" style="padding-right: 5px !important;">
                  <label>Ngày đặt <span class="red-star">*</span></label>
                  <input type="text" class="form-control datepicker" name="ngay_dat" id="ngay_dat" value="{{ old('ngay_dat', date('d-m-Y', strtotime($detail->ngay_dat))) }}">
                </div>                
                 <div class="form-group col-md-6">
                  <label>Tiền cọc <span class="red-star">*</span></label>
                  <input type="text" class="form-control number" name="tien_coc" id="tien_coc" value="{{ old('tien_coc', number_format($detail->tien_coc)) }}">
                </div>
                </div>
                <div class="form-group col-md-6 no-padding" style="padding-right: 5px !important;">
                    <label for="email">Hình thức <span class="red-star">*</span></label>
                    <select class="form-control select2" name="method_id" id="method_id">
                        <option value="">-- Chọn --</option>
                        @foreach( $methodList as $method )
                        <option value="{{ $method->id }}"
                        {{ old('method_id', $detail->method_id) == $method->id ? "selected" : "" }}                           
                        >{{ $method->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6 no-padding ">
                    <label for="email">Phương thức thanh toán <span class="red-star">*</span></label>
                    <select class="form-control select2" name="payment_id" id="payment_id">
                        <option value="">-- Chọn --</option>
                        @foreach( $paymentList as $payment )
                        <option value="{{ $payment->id }}"
                        {{ old('payment_id', $detail->payment_id) == $payment->id ? "selected" : "" }}                           
                        >{{ $payment->name }}</option>
                        @endforeach
                    </select>
                </div>                
                <div class="form-group" style="margin-bottom: 20px;">
                  <label for="email">Trạng thái</label>
                  <div class="clearfix"></div>
                  <div class="radio col-md-4">
                    <label>
                      <input type="radio" name="order_status" id="order_status1" value="1" @if(old('order_status', $detail->order_status) == 1 ) checked="checked" @endif>
                      Chưa giao
                    </label>
                  </div>
                  <div class="radio col-md-4">
                    <label>
                      <input type="radio" name="order_status" id="order_status2" value="2" @if(old('order_status', $detail->order_status) == 2 ) checked="checked" @endif>
                      Đã giao
                    </label>
                  </div>
                  <div class="radio col-md-4">
                    <label>
                      <input type="radio" name="order_status" id="order_status3" value="3" @if(old('order_status', $detail->order_status) == 3 ) checked="checked" @endif>
                      Khác
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="email">Trạng thái soạn</label>
                  <div class="clearfix"></div>
                  <div class="radio col-md-4">                    
                    <label>
                      <input type="radio" name="da_soan" id="da_soan1" value="1" @if(old('da_soan', $detail->da_soan) == 1 ) checked="checked" @endif>
                      Chưa soạn
                    </label>
                  </div>
                  <div class="radio col-md-4">
                    <label>
                      <input type="radio" name="da_soan" id="da_soan2" value="2" @if(old('da_soan', $detail->da_soan) == 2 ) checked="checked" @endif>
                      Đã soạn
                    </label>
                  </div>     
                  <div class="radio col-md-4"></div>             
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                  <label for="email">Liên hệ</label>
                  <div class="clearfix"></div>
                  <div class="radio col-md-4">
                    <label>
                      <input type="radio" name="call_status" id="call_status1" value="1"  @if(old('call_status', $detail->call_status) == 1) checked="checked" @endif>
                      Chưa gọi
                    </label>
                  </div>
                  <div class="radio col-md-4">
                    <label>
                      <input type="radio" name="call_status" id="call_status2" value="2"  @if(old('call_status', $detail->call_status) == 2 ) checked="checked" @endif>
                      Đã gọi
                    </label>
                  </div>     
                  <div class="radio col-md-4"></div>             
                </div>
                <div class="clearfix"></div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Ghi chú</label>
                  <textarea class="form-control" rows="4" name="description" id="description">{{ old('description', $detail->description) }}</textarea>
                </div> 
                
                <div class="form-group">
                  <div class="checkbox col-md-12" >
                    <label>
                      <input type="checkbox" name="not_form" value="1" id="not_form" {{ old('not_form', $detail->not_form) == 1 ? "checked" : "" }}>
                      KHÔNG THỬ FORM
                    </label>
                  </div>                 
                 
                </div>
                <div class="clearfix"></div>              
            </div>
            <!-- /.box-body -->                        
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('orders.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-4">
       
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<style type="text/css">
  .checkbox+.checkbox, .radio+.radio{
    margin-top: 10px !important;
  }
</style>
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
@stop
@section('javascript_page')
<script type="text/javascript">
var h = screen.height;
var w = screen.width;

    $(document).ready(function(){
            
      
      
      $('#name').change(function(){
         var name = $.trim( $(this).val() );
        
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
              }
            });        
      });

    });
    
</script>
@stop
