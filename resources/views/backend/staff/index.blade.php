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
    <li><a href="{{ route( 'staff.index' ) }}">Nhân viên</a></li>
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
      <a href="{{ route('staff.create') }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>      
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( <span class="value">{{ number_format($items->total()) }} nhân viên )</span></h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">             
              <table class="table table-bordered" id="table-list-data">
                <tr>             
                  <th style="width: 1%">#</th>                    
                  <th>Tên ngắn</th>
                  <th>Họ tên</th>
                  <th>Bộ phận</th>
                  <th width="120px">Điện thoại</th>
                  <th width="150px">Facebook</th>                  
                  <th width="1%;white-space:nowrap">Thao tác</th>
                </tr>
                <tbody>
                @if( $items->count() > 0 )
                  <?php $i = 0; ?>
                  @foreach( $items as $item )
                    <?php $i ++; ?>
                  <tr id="row-{{ $item->id }}">
                   
                    <td><span class="order">{{ $i }}</span></td>                        
                    <td>                  
                      <a href="{{ route( 'staff.edit', [ 'id' => $item->id ]) }}">{{ $item->short_name }}</a>
                    </td>
                    <td>{{ $item->full_name }}</td>
                    <td>
                        <?php 
                        if($item->type == 2) echo "- Tiếp nhận <br>"; 
                        if($item->type_1 == 1) echo "- May <br>"; 
                        if($item->type_2 == 3) echo "- Đính kết"; 
                        ?>
                      </td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->facebook_url }}</td>                   
                    <td style="white-space:nowrap">                                       
                      <a href="{{ route( 'staff.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm">
                        <i class="fa fa-fw fa-edit"></i>
                      </a>
                     
                      <a onclick="return callDelete('{{ $item->short_name }}','{{ route( 'staff.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm">
                        <i class="fa fa-fw fa-trash"></i>
                      </a>
                   
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