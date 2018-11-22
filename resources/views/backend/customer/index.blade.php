@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Khách hàng
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'customer.index' ) }}">Khách hàng</a></li>
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
      <a href="{{ route('customer.create') }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      <div class="panel panel-default">  
        <div class="panel-body">
          <form class="form-inline" role="form" method="GET" action="{{ route('customer.index') }}" id="searchForm">
            <div class="form-group">
              <label for="email">Tên KH / Số điện thoại :</label>
              <input type="text" class="form-control" name="keyword" value="{{ $keyword }}">
            </div>
            <div class="form-group">
              &nbsp;&nbsp;<label><input type="checkbox" id="no_order" name="no_order" value="1" {{ $no_order == 1 ? "checked" : "" }}> KHÔNG CÓ ĐƠN HÀNG</label>
            </div>
            <button type="submit" class="btn btn-default btn-sm">Lọc</button>
          </form>         
        </div>
      </div>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( <span class="value">{{ number_format($items->total()) }} khách hàng )</span></h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <form name="formUpdate" id="formUpdate" action="{{ route('customer.update-status') }}" method="post"> 
              {{ csrf_field() }}
              <input type="hidden" name="table" value="customer">
              <input type="hidden" name="change_column" id="change_column" value="status">
              <input type="hidden" name="change_value" id="change_value" value="0">
              <input type="hidden" name="backParam" value="{{ json_encode(array('no_order' => $no_order, 'keyword' => $keyword)) }}">
              <div style="margin-bottom: 3px">
               
                <button type="button" class="btn btn-danger btn-sm btnChangeStatus">Xóa</button>
              </div>
              <table class="table table-bordered" id="table-list-data">
                <tr>
                  <th style="width: 1%"><input type="checkbox" id="checkall"></th>  
                  <th style="width: 1%">#</th>                    
                  <th>Tên KH</th>
                  <th width="120px">Điện thoại</th>
                  <th width="150px">Email</th>
                  <th>Đơn hàng</th>
                  <th width="200px">Thông tin khác</th>
                  <th width="120px">Ngày tạo</th>                
                  <th width="1%;white-space:nowrap">Thao tác</th>
                </tr>
                <tbody>
                @if( $items->count() > 0 )
                  <?php $i = 0; ?>
                  @foreach( $items as $item )
                    <?php $i ++; ?>
                  <tr id="row-{{ $item->id }}">
                    <td>
                      @if($item->orders->count() == 0)
                      <input type="checkbox" class="select_orders" name="customer_id[]" value="{{ $item->id }}">
                      @endif
                    </td>  
                    <td><span class="order">{{ $i }}</span></td>                        
                    <td>                  
                      <a href="{{ route( 'customer.edit', [ 'id' => $item->id ]) }}">{{ $item->name }}</a>
                    </td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->email }}</td>
                    <td><span style="font-size:15px" class="badge badge-success">{{ $item->orders->count() }}</span></td>
                    <td>{{ $item->information }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                    <td style="white-space:nowrap">                  
                      <a href="{{ route( 'orders.index', [ 'customer_id' => $item->id ]) }}" class="btn btn-primary btn-sm" title="Thêm đơn hàng">
                        <i class="fa fa-fw fa-plus"></i>
                      </a>
                      <a href="{{ route( 'orders.index', [ 'customer_id' => $item->id ]) }}" class="btn btn-info btn-sm" title="Danh sách đơn hàng">
                        <i class="fa fa-fw fa-list-ul"></i>
                      </a>
                      <a href="{{ route( 'customer.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm">
                        <i class="fa fa-fw fa-edit"></i>
                      </a>
                      @if($item->orders->count() == 0)
                      <a onclick="return callDelete('{{ $item->name }}','{{ route( 'customer.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm">
                        <i class="fa fa-fw fa-trash"></i>
                      </a>
                      @endif
                    </td>
                  </tr> 
                  @endforeach
                @else
                <tr>
                  <td colspan="3">Không có dữ liệu.</td>
                </tr>
                @endif

              </tbody>
              </table>
            </form>
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
  a.color_code {
    display: block;
    width: 50px;
    height: 50px;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.29);
    border: 1px solid rgba(0, 0, 0, 0.2);
    text-align: center;
    line-height: 28px;
    font-size: 10px;
    color: #FFF;
}
</style>
@stop
@section('javascript_page')
<script type="text/javascript">
function callDelete(name, url){  
  swal({
    title: 'Bạn muốn xóa "' + name +'"?',
    text: "Dữ liệu sẽ không thể phục hồi.",
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
      alert('Chọn ít nhất 1 khách hàng.');
      return false;
    }else{
      if(confirm('Bạn chắc chắn muốn xóa những khách hàng đã chọn?')){
        
        $('#formUpdate').submit();
      }
    }    
    
  });
  $('#no_order').change(function(){    
    $('#searchForm').submit();
  });
  $('#checkall').change(function(){
    if($(this).prop('checked') == true){
      $('#table-list-data input[type=checkbox]').prop('checked', 'checked');
    }else{
      $('#table-list-data input[type=checkbox]').removeAttr('checked');
    }
  });
});
</script>
@stop