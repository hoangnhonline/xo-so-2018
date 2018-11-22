@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Đơn hàng @if($paramArr['type'] == 2) trễ @endif
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'orders.index' ) }}">Đơn hàng</a></li>
    <li class="active">Danh sách</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
      <a href="{{ route('orders.create') }}?backParam={{ json_encode($paramArr) }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      <div class="panel panel-default">        
        <div class="panel-body">
          <form class="form-inline" id="searchForm" role="form" method="GET" action="{{ route('orders.index') }}">
            <div class="form-group">
              <label><input type="checkbox" id="type" name="type" value="2" {{ $paramArr['type'] == 2 ? "checked" : "" }}> ĐƠN HÀNG TRỄ</label>
            </div>  
            <div class="form-group" style="margin-bottom: 5px">             
              <select class="form-control select2 selectChange" name="customer_id" id="customer_id">
                <option value="">--Tên KH/Số ĐT--</option>
                @foreach($customerList as $customer)
                <option value="{{ $customer->id }}" {{ $paramArr['customer_id'] == $customer->id ? "selected" : "" }}>{{ $customer->phone }}-{{ $customer->name }}</option>
                @endforeach
              </select>
            </div>
            @if($paramArr['type'] == 1)
            <div class="form-group">             
              <select class="form-control selectChange" name="order_status" id="order_status">
                <option value="">--Trạng thái giao--</option>
                <option value="1" {{ $paramArr['order_status'] == 1 ? "selected" : "" }}>Chưa giao</option>
                <option value="2" {{ $paramArr['order_status'] == 2 ? "selected" : "" }}>Đã giao</option>
                <option value="3" {{ $paramArr['order_status'] == 3 ? "selected" : "" }}>Khác</option>
              </select>
            </div>  
            <div class="form-group">             
              <select class="form-control selectChange" name="da_soan" id="da_soan">
                <option value="">--Trạng thái soạn--</option>
                <option value="1" {{ $paramArr['da_soan'] == 1 ? "selected" : "" }}>Chưa soạn</option>
                <option value="2" {{ $paramArr['da_soan'] == 2 ? "selected" : "" }}>Đã soạn</option>                
              </select>
            </div> 
            
            <div class="form-group">              
              <input type="text" class="form-control datepicker" name="from_date" id="from_date" value="{{ $paramArr['from_date'] }}" placeholder="Ngày giao từ">
            </div>  
            <div class="form-group">              
              <input type="text" class="form-control datepicker" name="to_date" id="to_date" value="{{ $paramArr['to_date'] }}" placeholder="Ngày giao đến">
            </div>
            @endif
            <button type="submit" style="margin-top:-5px" class="btn btn-primary btn-sm">Lọc</button>
          </form>         
        </div>
      </div>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách [ {{ $items->total() }} đơn hàng ]</h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:center">
           {{ $items->appends( $paramArr )->links() }}
          </div>  
         
          <form name="formUpdate" id="formUpdate" action="{{ route('orders.update-status') }}" method="post"> 
            {{ csrf_field() }}
            <input type="hidden" name="table" value="product">
            <input type="hidden" name="change_column" id="change_column" value="">
            <input type="hidden" name="change_value" id="change_value">
            <input type="hidden" name="backParam" value="{{ json_encode($paramArr) }}">
            <div class="table-responsive">
              <div style="margin-bottom: 3px">
                <button type="button" class="btn btn-success btn-sm btnChangeStatus" data-column="da_soan" data-value="2">Đã soạn</button>
                <button type="button" class="btn btn-danger btn-sm btnChangeStatus" data-column="order_status" data-value="2">Đã giao</button>
              </div>
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%"></th>              
              <th style="width: 1%">#</th>              
              <th>Thông tin</th>
              <th width="100px">Tiến độ</th>
              <th width="40px">SP</th>                              
              <th width="80px" style="text-align:center">Tổng tiền</th>
              <th width="80px" style="text-align:right">Trạng thái</th>
              <th width="95px">Form</th>              
              <th width="95px">Ngày giao</th>              
              <th width="1%;white-space:nowrap">Thao tác</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = ($items->currentPage() - 1)* config('sites.pagination'); ?>
              @foreach( $items as $item )
                <?php $i ++; ?>
              <tr id="row-{{ $item->id }}">
                <td>
                  <input class="select_orders" type="checkbox" name="order_id[]" value="{{ $item->id }}">
                </td>
                <td><span class="order">{{ $i }}</span></td>
                <td>                  
                  <a style="color:blue;font-size:15px;" href="{{ route('orders-detail.index', $item->id )}}?backParam={{ json_encode($paramArr) }} " title="Chi tiết đơn hàng">
                    @if($item->customer)
                    {{ $item->customer->name }} - {{ $item->customer->phone }}
                    @endif
                  </a>
                  <br /> 
                  {{ $item->payment_id > 0 ? $item->payment->name : '' }} - {{ $item->method_id > 0 ? $item->method->name : '' }}     
                  <br>
                  
                  @if($item->not_form == 1)
                    <span style="color:#9e049e;font-size:12px;">Không thử form</span>
                  @endif   
                  <br>
                  <span style="font-style: italic;color:red;">{{ $item->description }}</span>
                </td>
                <td>
                  <?php echo date('d-m-Y', strtotime($item->ngay_dat)); ?>
                  <br>
                  @php
                  $arr = array();        
                  $dataList = \DB::table('order_detail')
                           ->select('process', DB::raw('count(id) as total'))
                           ->where('order_id', $item->id)
                           ->groupBy('process')
                           ->get();
                  foreach($dataList as $data){
                      if($data->total > 0){
                          $arr[$data->process] = $data->total;
                      }
                  }    
                  @endphp                            
                  @foreach($arr as $process => $totalProcess)                  
                  <?php if($process == 1) { ?>
                      <span class="label" style="color:#FFF; background-color: #999">
                        Chưa làm
                      
                    <?php }else if($process == 2) { ?>
                    <span class="label" style="background-color:#C8AA04;margin-bottom:3px">
                        Đang làm
                      
                    <?php }else if($process == 3) { ?>
                    <span class="label label-info">
                        Làm xong
                      
                    <?php }else if($process == 4) { ?>
                    <span class="label label-inverse">
                        Đã giao
                     
                    <?php } ?>
                  [<?php echo $totalProcess; ?>]
                   </span>
                  @endforeach              
                                 
                  
                </td>
                <td style="text-align:center">
                  {{ $item->total_product }}
                </td>
                <td style="text-align:right">
                  <?php  
                  if($item->total_price == 0){
                     $tong_tien = \DB::table('order_detail')->where('status', 1)->where('order_id', $item->id)->sum('total_price'); 
                   }else{
                    $tong_tien = $item->total_price;
                   }
                 
                 
                  ?>
                  {{ number_format($tong_tien) }}

                  <br /> <span style="color:#2DC7D1"> <?php echo number_format($item->tien_coc); ?>
                </td>
                <td style="text-align: left">
                <?php if($item->call_status==1) echo '<span class="label" style="background-color:#928f92;margin-bottom:3px">Chưa gọi</span>'; 
                 if($item->call_status == 2 ) echo '<span class="label label-info"><i class="icon-phone"></i> Đã gọi</span>'; ?>
                 <br>              
                    <?php                    
                  if ($item->order_status == 2) echo '<span class="label label-success">Đã giao</span>' ;
                  if($item->order_status == 1) echo '<span class="label label-important" style="background-color:#e74955; color:#FFF">Chưa giao</span> &nbsp;'; 
                  if($item->order_status == 3) echo '<span class="label label-important">Khác</span>';
                  if($item->da_soan == 2 && $item->order_status != 2) echo '<span class="label label-success">Đã soạn</span>';
                  ?>
                </td>
                <td>
                  @php
                  $arr = array();        
                  $dataList = \DB::table('order_detail')
                           ->select('form_status_id', DB::raw('count(id) as total'))
                           ->where('order_id', $item->id)
                           ->groupBy('form_status_id')
                           ->get();
                  foreach($dataList as $data){
                      if($data->total > 0){
                          $arr[$data->form_status_id] = $data->total;
                      }
                  }
                  @endphp      
                  @if(!empty($arr))
                    @foreach($arr as $form_status_id => $totalProduct)     
                      @if(isset($formStatusArr[$form_status_id]))
                      <span class="label" style="margin-bottom:3px;background-color:{{ $formStatusArr[$form_status_id]->color_code }}">{{ $formStatusArr[$form_status_id]->value }} [<?php echo $totalProduct; ?>]</span> @endif
                    @endforeach
                  @endif
                </td>                
                <td class="center" style="text-align: center;color:red;font-weight:bold;white-space: nowrap;">
                  <?php echo date('d-m-Y', strtotime($item->ngay_giao)); ?>
                </td>                        
                <td style="white-space:nowrap; text-align:right">                 
                  <a href="{{ route( 'orders.edit', [ 'id' => $item->id ]) }}?backParam={{ json_encode($paramArr) }}" class="btn btn-warning btn-sm">
                    <i class="fa fa-fw fa-edit"></i>
                  </a>                 
                  @if($item->customer)
                  <a onclick="return callDelete('{{ $item->id }} của {{ $item->customer->name }}','{{ route( 'orders.destroy', [ 'id' => $item->id ]) }}?backParam={{ json_encode($paramArr) }}');" class="btn btn-danger btn-sm">
                    <i class="fa fa-fw fa-trash"></i>
                  </a>                  
                  @endif

                </td>
              </tr> 
              @endforeach
            @else
            <tr>
              <td colspan="9">Không có dữ liệu.</td>
            </tr>
            @endif

          </tbody>
          </table>          
              <div style="margin-bottom: 3px">            
                <button type="button" class="btn btn-success btn-sm btnChangeStatus" data-column="da_soan" data-value="2">Đã soạn</button>
                <button type="button" class="btn btn-danger btn-sm btnChangeStatus" data-column="order_status" data-value="2">Đã giao</button>
              </div>
            </div>
        </div>
      </form>
         
          <div style="text-align:center;margin-top: 5px">
           {{ $items->appends( $paramArr )->links() }}
          </div>  
        </div>        
      </div>
      <!-- /.box -->     
    </div>
    <!-- /.col -->  
  </div> 
</section>
<!-- /.content -->
</div>
<style type="text/css">
#searchForm div{
  margin-right: 7px;
}
</style>
@stop
@section('javascript_page')
<script type="text/javascript">
function callDelete(name, url){  
  swal({
    title: 'Bạn muốn xóa đơn hàng ' + name +'?',
    text: "Dữ liệu sẽ vào thùng rác.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then(function() {
    location.href= url;
  })
  return flag;
}
$(document).ready(function(){
  $('button.btnChangeStatus').click(function(){
    var obj = $(this);
    if($('.select_orders:checked').length == 0){ 
      alert('Chọn ít nhất 1 đơn hàng.');
      return false;
    }else{
      if(confirm('Bạn chắc chắn muốn cập nhật những đơn hàng đã chọn?')){
        $('#change_column').val(obj.data('column'));
        $('#change_value').val(obj.data('value'));
        $('#formUpdate').submit();
      }
    }    
    
  });
  $('.change-value').change(function(){
    var obj = $(this);
    var val = 0;
    if(obj.prop('checked') == true){
      var val = 1;
    }
    $.ajax({
      url : "{{ route('change-value') }}",
      type :'POST',
      data : {
        id : obj.data('id'),
        value : val,
        column : obj.data('col'),
        table : obj.data('table')
      },
      success : function(data){
        console.log(data);
      }
    });
  });
  $('input.submitForm').click(function(){
    var obj = $(this);
    if(obj.prop('checked') == true){
      obj.val(1);      
    }else{
      obj.val(0);
    } 
    obj.parent().parent().parent().submit(); 
  });
  
  $('.selectChange, #type').change(function(){    
    $('#searchForm').submit();
  });

});

</script>
@stop