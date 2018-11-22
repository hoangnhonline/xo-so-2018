@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Chi tiết đơn hàng : {{ $orderInfo->customer->name }} - {{ $orderInfo->customer->phone }} [{{$orderInfo->id}}]
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'orders-detail.index', $orderInfo->id ) }}">Chi tiết đơn hàng</a></li>
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
      @if($backUrl)
      <a class="btn btn-default btn-sm" href="{{ $backUrl }}" style="margin-bottom:5px">Quay lại</a>
      @else
      <a class="btn btn-default btn-sm" href="{{ route('orders.index') }}" style="margin-bottom:5px">Quay lại</a>
      @endif
      
      <a href="{{ route('orders-detail.create', $orderInfo->id) }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Thêm sản phẩm</a>
      
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( <span class="value">{{ $detailList->count() }} sản phẩm )</span></h3>
        </div>
        @php
          $haveImg = false;
          foreach($detailList as $item){
            if($item->status == 1 && $item->image_url){
              $haveImg = true;
            }
          }
        @endphp        
        <!-- /.box-header -->
        <div class="box-body">

          <div class="table-responsive">
            <table class="table table-bordered" id="table-list-data">
              <tr>
                <th>Mã SP</th>
                @if($haveImg)
                <th width="120px">Hình ảnh</th>
                @endif
                <th>Thông tin</th>
                <th  width="150px">Nhân viên</th>
                <th  width="120px">Ngày giao</th>
                <th  width="120px">Tổng tiền</th>
                <th  width="80px">Trạng thái</th>
                <th width="1%;white-space:nowrap">Thao tác</th>
              </tr>
              <tbody>
              @if( $detailList->count() > 0 )
           
                @foreach( $detailList as $item )
                 @if($item->status == 1)
                <tr id="row-{{ $item->id }}">
                    
                  <td>                  
                    {{ $item->product_code }}<br /> 
                    <font color="#2DC7D1">{{ $item->loai->name }}</font>
                    <br /><br />
                        
                    @if($item->form_status_id > 0)             
                      Form : 
                      <span class="label" style="background-color:{{ $item->formStatus->color_code }}">               
                      @if($item->form_status_id != 6)
                        {{ $item->formStatus->value }}
                      @else
                        <i class="fas fa-user-alt-slash"></i>
                      @endif   
                      </span>
                    @endif                    
                    @if($item->form_ok_id > 0)
                    <span style="color: {{ $item->formOk->color_code }}">{{ $item->formOk->value }}</span>
                    @endif
                  </td>
                  @if($haveImg)
                  <td>
                    <?php
                    $image_url = $item->image_url ? $item->image_url : URL::asset('public/assets/dist/img/no-image.jpg');
                    ?>
                    <img src="{{ $image_url }}" width="120" style="border:1px solid #CCC">
                  </td>
                  @endif
                  <td>
                    @if($item->mau_id > 0)
                    Màu : {{ $item->mau->name }}<br>
                    @endif
                    @if($item->size_id > 0)
                    Size : {{ $item->size->name }}<br>
                    @endif
                    @if($item->kieu_id > 0)
                    Kiểu : {{ $item->kieu->name }}<br>
                    @endif<br>
                    <span style="color:red;font-style: italic;">{{ $item->notes }}</span>
                  </td>
                  <td>
                    @if($item->nguoi_nhan > 0)                    
                    Nhận : <span style="color: blue">{{ $item->nhan->short_name }}</span><br>
                    @endif
                    @if($item->staff_rap > 0)
                    Rập : <span style="color: blue">{{ $item->rap->short_name }}</span><br>
                    @endif
                    @if($item->staff_cat > 0)
                    Cắt : <span style="color: blue">{{ $item->cat->short_name }}</span><br>
                    @endif
                    @if($item->staff_may > 0)
                    May : <span style="color: blue">{{ $item->may->short_name }}</span><br>
                    @endif
                    @if($item->staff_ren > 0)
                    Ren : <span style="color: blue">{{ $item->ren->short_name }}</span><br>
                    @endif
                    @if($item->staff_cuom > 0)
                    Cườm : <span style="color: blue">{{ $item->cuom->short_name }}</span><br>
                    @endif
                  </td>
                  <td>
                    @if(App\Models\OrderDetail::deliveryDate($item->id)->count() > 0)
                    <?php $i = 0; ?>
                      @foreach(App\Models\OrderDetail::deliveryDate($item->id) as $date)
                      <?php $i++; ?>
                      @if($i == 1)
                      <span style="color:red">{{ date('d-m-y', strtotime($date->ngay_giao)) }}</span>
                      @else
                      {{ date('d-m-y', strtotime($date->ngay_giao)) }}
                      @endif
                      @endforeach
                    @endif
                  </td>
                  <td style="text-align:right;white-space: nowrap;">
                      <?php echo number_format($item->price);?> x <?php echo $item->number_product; ?>
                      <br>
                      <?php echo number_format($item->total_price);?>
                  </td>
                  <td style="text-align: right">
                    <?php if($item->process == 1) { ?>
                      <span class="label">
                        Chưa làm
                      </span>
                    <?php }else if($item->process == 2) { ?>
                    <span class="label" style="background-color:#C8AA04;margin-bottom:3px">
                        Đang làm
                      </span>
                    <?php }else if($item->process == 3) { ?>
                    <span class="label label-info">
                        Làm xong
                      </span>
                    <?php }else if($item->process == 4) { ?>
                    <span class="label label-inverse">
                        Đã giao
                      </span>
                    <?php } ?>
                    </td>
                  <td style="white-space:nowrap">                  
                    <a href="{{ route( 'orders-detail.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm">
                      <i class="fa fa-fw fa-edit"></i>
                    </a>                 
                    
                    <a onclick="return callDelete('{{ $item->product_code }}','{{ route( 'orders-detail.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm">
                      <i class="fa fa-fw fa-trash"></i>
                    </a>
                    
                  </td>
                </tr> 
                @endif
                @endforeach
              @else
              <tr>
                <td colspan="3">Không có dữ liệu.</td>
              </tr>
              @endif

            </tbody>
            </table>
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
</script>
@stop