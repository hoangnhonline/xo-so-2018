@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Khách hàng : {{ $detail->name }}
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('customer.index') }}">Khách hàng</a></li>
      <li class="active">Cập nhật</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-info btn-sm" href="{{ route('orders.create',[ 'customer_id' => $detail->id] ) }}&backUrl={{ route('customer.edit', $detail->id)}}" style="margin-bottom:5px">Thêm đơn hàng</a>
    <a class="btn btn-default btn-sm" href="{{ route('customer.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('customer.update') }}">
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
              <div class="row">
                <div class="form-group col-md-6">
                  <label>Họ tên<span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $detail->name) }}">
                </div>
                <div class="form-group col-md-6">
                  <label>Điện thoại<span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $detail->phone) }}">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <label>Email</label>
                  <input type="text" class="form-control" name="email" id="email" value="{{ old('email', $detail->email) }}">
                </div>
                <div class="form-group col-md-6">
                  <label>Địa chỉ</label>
                  <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $detail->address) }}">
                </div>
              </div> 
              <div class="row">
                <div class="form-group col-md-2">
                  <label>Vòng ngực</label>
                  <input type="text" class="form-control" name="vong_nguc" id="vong_nguc" value="{{ old('vong_nguc', $detail->vong_nguc) }}">
                </div>
                <div class="form-group col-md-2">
                  <label>Hạ eo sau</label>
                  <input type="text" class="form-control" name="ha_eo" id="ha_eo" value="{{ old('ha_eo', $detail->ha_eo) }}">
                </div>
                <div class="form-group col-md-2">
                  <label>Vòng cổ</label>
                  <input type="text" class="form-control" name="vong_co" id="vong_co" value="{{ old('vong_co', $detail->vong_co) }}">
                </div>
                <div class="form-group col-md-2">
                  <label>Khuỷ tay</label>
                  <input type="text" class="form-control" name="vong_day" id="vong_day" value="{{ old('vong_day', $detail->vong_day) }}">
                </div>
              
                <div class="form-group col-md-2">
                  <label>Vòng eo</label>
                  <input type="text" class="form-control" name="vong_eo" id="vong_eo" value="{{ old('vong_eo', $detail->vong_eo) }}">
                </div>
                <div class="form-group col-md-2">
                  <label>Rộng vai</label>
                  <input type="text" class="form-control" name="rong_vai" id="rong_vai" value="{{ old('rong_vai', $detail->rong_vai) }}">
                </div>
                </div><!-- // end row -->            
              <div class="row">
                <div class="form-group col-md-2">
                  <label>Vòng nách</label>
                  <input type="text" class="form-control" name="vong_nach" id="vong_nach" value="{{ old('vong_nach', $detail->vong_nach) }}">
                </div>
                <div class="form-group col-md-2">
                  <label>Chéo ngực</label>
                  <input type="text" class="form-control" name="vong_nguc_tren" id="vong_nguc_tren" value="{{ old('vong_nguc_tren', $detail->vong_nguc_tren) }}">
                </div>
              
                <div class="form-group col-md-2">
                  <label>Vòng mông</label>
                  <input type="text" class="form-control" name="vong_mong" id="vong_mong" value="{{ old('vong_mong', $detail->vong_mong) }}">
                </div>
                <div class="form-group col-md-2">
                  <label>Chiều dài tay áo</label>
                  <input type="text" class="form-control" name="dai_tay_ao" id="dai_tay_ao" value="{{ old('dai_tay_ao', $detail->dai_tay_ao) }}">
                </div>
                <div class="form-group col-md-2">
                  <label>Bắp tay</label>
                  <input type="text" class="form-control" name="bap_tay_tren" id="bap_tay_tren" value="{{ old('bap_tay_tren', $detail->bap_tay_tren) }}">
                </div>
                <div class="form-group col-md-2">
                  <label>Cửa tay</label>
                  <input type="text" class="form-control" name="vong_nguc_duoi" id="vong_nguc_duoi" value="{{ old('vong_nguc_duoi', $detail->vong_nguc_duoi) }}">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-2">
                  <label>Hạ ngực</label>
                  <input type="text" class="form-control" name="ha_nguc" id="ha_nguc" value="{{ old('ha_nguc', $detail->ha_nguc) }}">
                </div>
                <div class="form-group col-md-2">
                  <label>Dài raglan</label>
                  <input type="text" class="form-control" name="dai_raglan" id="dai_raglan" value="{{ old('dai_raglan', $detail->dai_raglan) }}">
                </div>
                <div class="form-group col-md-2">
                  <label>Bụng</label>
                  <input type="text" class="form-control" name="bap_tay_duoi" id="bap_tay_duoi" value="{{ old('bap_tay_duoi', $detail->bap_tay_duoi) }}">
                </div>
                <div class="form-group col-md-2">
                  <label>C.dài quần, váy</label>
                  <input type="text" class="form-control" name="dai_quan" id="dai_quan" value="{{ old('dai_quan', $detail->dai_quan) }}">
                </div>
              
                <div class="form-group col-md-2">
                  <label>Bắp tay dưới</label>
                  <input type="text" class="form-control" name="them_1" id="them_1" value="{{ old('them_1', $detail->them_1) }}">
                </div>
                <div class="form-group col-md-2">
                  <label>Dài áo (dài đầm)</label>
                  <input type="text" class="form-control" name="dai_ao" id="dai_ao" value="{{ old('dai_ao', $detail->dai_ao) }}">
                </div>
                </div>
              <div class="row">
                <div class="form-group col-md-2">
                  <label>Hạ tim</label>
                  <input type="text" class="form-control" name="them_3" id="them_3" value="{{ old('them_3', $detail->them_3) }}">
                </div>
                <div class="form-group col-md-2">
                  <label>Giầy</label>
                  <input type="text" class="form-control" name="them_4" id="them_4" value="{{ old('them_4', $detail->them_4) }}">
                </div>
                <div class="form-group col-md-2">
                  <label>Hạ xẻ</label>
                  <input type="text" class="form-control" name="them_2" id="them_2" value="{{ old('them_2', $detail->them_2) }}">
                </div>
                <div class="form-group col-md-6">
                  <label>Thông tin thêm</label>
                  <input type="text" class="form-control" name="information" id="information" value="{{ old('information', $detail->information) }}">
                </div>
              </div>               
            </div>              
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('customer.index')}}">Hủy</a>
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