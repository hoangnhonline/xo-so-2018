@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Cài đặt site
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('settings.index') }}">Cài đặt</a></li>
      <li class="active">Cập nhật</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">   
    <form role="form" method="POST" action="{{ route('settings.update') }}">
    <div class="row">
      <!-- left column -->

      <div class="col-md-7">
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
              @if(Session::has('message'))
              <p class="alert alert-info" >{{ Session::get('message') }}</p>
              @endif
                 <!-- text input -->
                <div class="form-group">
                  <label>Tên site <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="site_name" id="site_name" value="{{ $settingArr['site_name'] }}">
                </div>
                
                <div class="form-group">
                  <label>Facebook</label>
                  <input type="text" class="form-control" name="facebook_fanpage" id="facebook_fanpage" value="{{ $settingArr['facebook_fanpage'] }}">
                </div>
                <div class="form-group">
                  <label>Facebook APP ID</label>
                  <input type="text" class="form-control" name="facebook_appid" id="facebook_appid" value="{{ $settingArr['facebook_appid'] }}">
                </div>
                <div class="form-group">
                  <label>Google +</label>
                  <input type="text" class="form-control" name="google_fanpage" id="google_fanpage" value="{{ $settingArr['google_fanpage'] }}">
                </div>
                <div class="form-group">
                  <label>Hotline</label>
                  <input type="text" class="form-control" name="hotline" id="hotline" value="{{ $settingArr['hotline'] }}">
                </div>
		<div class="form-group">
                  <label>Giờ làm việc</label>
                  <input type="text" class="form-control" name="gio_lam_viec" id="gio_lam_viec" value="{{ $settingArr['gio_lam_viec'] }}">
                </div>
<div class="form-group">
                  <label>Email header</label>
                  <input type="text" class="form-control" name="email_header" id="email_header" value="{{ $settingArr['email_header'] }}">
                </div>
                <div class="form-group">
                  <label>Email CC</label>
                  <textarea class="form-control" rows="3" name="email_cc" id="email_cc">{{ $settingArr['email_cc'] }}</textarea>
                </div>
                <div class="form-group">
                  <label>Thông tin công ty</label>
                  <textarea class="form-control" rows="7" name="thong_tin_cong_ty" id="thong_tin_cong_ty">{{ $settingArr['thong_tin_cong_ty'] }}</textarea>
                </div>
                <div class="form-group">
                  <label>Thông báo đặt hàng thành công</label>
                  <textarea class="form-control" rows="7" name="thong_bao_thanh_cong" id="thong_bao_thanh_cong">{{ $settingArr['thong_bao_thanh_cong'] }}</textarea>
                </div>
                <div class="form-group">
                  <label>Code google analystic </label>
                  <input type="text" class="form-control" name="google_analystic" id="google_analystic" value="{{ $settingArr['google_analystic'] }}">
                </div>  
                  <div class="form-group">
                  <label>Maps</label>
                  <textarea class="form-control" rows="7" name="maps" id="maps">{{ $settingArr['maps'] }}</textarea>
                </div>
                <div class="form-group col-md-12" style="margin-top:10px;margin-bottom:10px">  
                  <label class="col-md-4 row">Logo ( 255 x 55 px )</label>    
                  <div class="col-md-8 div-upload">
                    <img class="show_thumbnail logo" src="{{ $settingArr['logo'] ? Helper::showImage($settingArr['logo']) : URL::asset('admin/dist/img/img.png') }}" class="img-logo" width="150" >
                    
                    <input type="file" data-value="logo" class="click-choose-file" style="display:none" />
                 
                    <button class="btn btn-default btn-sm btnUploadImage" data-value="logo"  data-choose="file-logo" type="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload</button>
                  </div>
                  <div style="clear:both"></div>
                </div>
                <div style="clear:both"></div>            
                <div class="form-group col-md-12" style="margin-top:10px;margin-bottom:10px">  
                  <label class="col-md-4 row">Banner ( og:image ) </label>    
                  <div class="col-md-8 div-upload">
                    <img class="show_thumbnail banner" src="{{ $settingArr['banner'] ? Helper::showImage($settingArr['banner']) : URL::asset('admin/dist/img/img.png') }}" class="img-banner" width="200">                  
                    <button class="btn btn-default btn-sm btnUploadImage" data-value="banner" type="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload</button>
                  </div>
                  <div style="clear:both"></div>
                </div>
                <div style="clear:both"></div>            
                 
            </div>                        
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>         
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-5">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Thông tin SEO</h3>
          </div>
          <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <label>Meta title <span class="red-star">*</span></label>
                <input type="text" class="form-control" name="site_title" id="site_title" value="{{ $settingArr['site_title'] }}">
              </div>
              <!-- textarea -->
              <div class="form-group">
                <label>Meta desciption <span class="red-star">*</span></label>
                <textarea class="form-control" rows="4" name="site_description" id="site_description">{{ $settingArr['site_description'] }}</textarea>
              </div>  

              <div class="form-group">
                <label>Meta keywords <span class="red-star">*</span></label>
                <textarea class="form-control" rows="4" name="site_keywords" id="site_keywords">{{ $settingArr['site_keywords'] }}</textarea>
              </div>  
              <div class="form-group">
                <label>Custom text</label>
                <textarea class="form-control" rows="4" name="custom_text" id="custom_text">{{ $settingArr['custom_text'] }}</textarea>
              </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <!--/.col (left) -->      
    </div>
<input type="hidden" name="logo" id="logo" value="{{ $settingArr['logo'] }}"/>         

<input type="hidden" name="favicon" id="favicon" value="{{ $settingArr['favicon'] }}"/>         

<input type="hidden" name="banner" id="banner" value="{{ $settingArr['banner'] }}"/>          


    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
@stop
@section('javascript_page')
<script type="text/javascript">
var h = screen.height;
var w = screen.width;
var left = (screen.width/2)-((w-300)/2);
var top = (screen.height/2)-((h-100)/2);
function openKCFinder_singleFile(obj_str) {
  alert('123');
      window.KCFinder = {};
      window.KCFinder.callBack = function(url) {
         $('#' + obj_str).val(url);
         $('.show_thumbnail.' + obj_str).attr('src', $('#app_url').val() + url);
          window.KCFinder = null;
      };
      window.open('{{ URL::asset("admin/dist/js/kcfinder/browse.php?type=images") }}', 'kcfinder_single','scrollbars=1,menubar=no,width='+ (w-300) +',height=' + (h-300) +',top=' + top+',left=' + left);
  }
    $(document).ready(function(){     
      $('.btnUploadImage').click(function(){
        openKCFinder_singleFile($(this).data('value'));
        //$(this).parents('.div-upload').find('.click-choose-file').click();
      });
      var editor = CKEDITOR.replace( 'thong_tin_cong_ty',{
          language : 'vi',       
          height : 300,
          toolbarGroups : [            
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },          
            { name: 'links', groups: [ 'links' ] },           
            '/',            
          ]
      });
      var editor = CKEDITOR.replace( 'thong_bao_thanh_cong',{
          language : 'vi',       
          height : 400,
          toolbarGroups : [            
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },          
            { name: 'links', groups: [ 'links' ] },           
            '/',            
          ]
      });

    });
    
</script>
@stop
