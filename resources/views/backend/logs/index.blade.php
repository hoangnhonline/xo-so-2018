@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Size 
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'size.index' ) }}">Size</a></li>
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
      <a href="{{ route('size.create') }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>    
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách</h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:center">
           {{ $items->appends( $paramArr )->links() }}
          </div>
          <table class="table table-bordered" id="table-list-data">            <tr>
              <th style="width: 1%">#</th>
              <th>Logs</th>      
              <th width="1%" style="white-space:nowrap">Thời gian</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; 

                ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order">{{ $i }}</span></td>
               
                <td>   
                  {{ $item->user->full_name }}
                 
                  @if($item->action == 1)
                  tạo
                  @elseif($item->action == 2)
                  cập nhật
                  @elseif($item->action == 3)
                  xóa
                  @else
                  chuyển trạng thái 
                  <?php 
                  $newData = json_decode($item->new_data, true);
                  if($newData['change_column'] == 'order_status'){
                    echo " ĐÃ SOẠN ";
                  }else{
                    echo " ĐÃ GIAO ";
                  }
                  ?>

                  @endif


                  @if($item->type == 1)
                  <?php 
                  $orders = $item->orders;
                  $customerDetail = $orders->customer;
                  ?>
                  đơn hàng 
                  @if(!empty((array)$customerDetail))
                  <a  target="_blank" href="{{ route('orders.index', ['customer_id' => $customerDetail->id])}}">[{{ $item->object_id }}]</a> của
                  
                  <a target="_blank" href="{{ route('customer.edit',$customerDetail->id)}}">{{ $customerDetail->name }} - {{ $customerDetail->phone }}</a>
                  @else
                  [{{ $item->object_id }}]
                  @endif
                  @elseif($item->type == 2)
                  chi tiết đơn hàng
                  <?php 
                  $orderDetail = $item->orderDetail;
                  $order_id = $orderDetail->order_id;
                  $orders = $orderDetail->orders;
                  $customerDetail = $orders->customer;
                  ?>
                  <a target="_blank" href="{{ route('orders.index', ['customer_id' => $customerDetail->id])}}">[{{ $order_id }}]</a> của <a target="_blank" href="{{ route('customer.edit',$customerDetail->id)}}">{{ $customerDetail->name }} - {{ $customerDetail->phone }}</a>

                  @elseif($item->type == 3)

                  khách hàng <a target="_blank" href="{{ route('customer.edit',$item->object_id)}}">[{{ $item->object_id }}]
                    @if($item->customer)
                   {{ $item->customer->name }} - {{ $item->customer->phone }}
                   @endif
                 </a>

                  @else
                  nhân viên {{ $item->staff->short_name }}
                  @endif
                </td>
                
                         
                <td style="white-space:nowrap">                 
                  {{ date('d/m/Y H:i', strtotime($item->created_at)) }}
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
          <div style="text-align:center">
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
  $('#parent_id').change(function(){
    $('#searchForm').submit();
  });
  $('#table-list-data tbody').sortable({
        placeholder: 'placeholder',
        handle: ".move",
        start: function (event, ui) {
                ui.item.toggleClass("highlight");
        },
        stop: function (event, ui) {
                ui.item.toggleClass("highlight");
        },          
        axis: "y",
        update: function() {
            var rows = $('#table-list-data tbody tr');
            var strOrder = '';
            var strTemp = '';
            for (var i=0; i<rows.length; i++) {
                strTemp = rows[i].id;
                strOrder += strTemp.replace('row-','') + ";";
            }     
            updateOrder("loai_thuoc_tinh", strOrder);
        }
    });
});
function updateOrder(table, strOrder){
  $.ajax({
      url: $('#route_update_order').val(),
      type: "POST",
      async: false,
      data: {          
          str_order : strOrder,
          table : table
      },
      success: function(data){
          var countRow = $('#table-list-data tbody tr span.order').length;
          for(var i = 0 ; i < countRow ; i ++ ){
              $('span.order').eq(i).html(i+1);
          }                        
      }
  });
}
</script>
@stop