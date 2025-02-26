@extends('admin-back-end')
@section('title', 'SEO Settings')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li><a>SEO</a></li>')
@section('content')
<?php 
use App\Helpers\Session as AppSession;
$adminData = AppSession::getLoginData();
?>
<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">

      <!-- form start -->
      <?php if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) { ?>    
      <form role="form" method="post" action="" novalidate  enctype="multipart/form-data">
      <?php } ?>
        <div class="box-body">
          <div class="box-header with-border">
            <h3 class="box-title">SEO Meta</h3>
          </div><!-- /.box-header -->

          <div class="form-group">
            <label for="siteName">Nombre del sitio</label>
            <input type="text" class="form-control" name="siteName" id="title" placeholder="" maxlength="100" value="{{Request::old('siteName', $settings->siteName)}}">
            <label class="text-red">{{$errors->first('siteName')}}</label>
          </div>
          <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="" maxlength="160" value="{{Request::old('title', $settings->title)}}">
            <label class="text-red">{{$errors->first('title')}}</label>
          </div>
          <div class="form-group">
            <label for="description">Descripción</label>
            <input type="text" class="form-control" name="description" id="description" placeholder="" maxlength="160" value="{{Request::old('description',$settings->description)}}">
            <label class="text-red">{{$errors->first('description')}}</label>
          </div>
          <div class="form-group">
            <label for="keywords">Keywords</label>
            <input type="text" class="form-control" name="keywords" id="keywords" placeholder="" maxlength="160" value="{{Request::old('keywords', $settings->keywords)}}">
            <label class="text-red">{{$errors->first('keywords')}}</label>
            <p class="help-block">Exam: key1, key2, ...</p>
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Logo</label>
            <div style="height: 22px;">
              <div style="width: 50%;float: left;">
                <input type="file" id="logo" name="logo" value="{{Request::old('logo')}}">
              </div>
              <div style="width: 50%;float: left;">
              @if(file_exists(PATH_UPLOAD.'/'.$settings->logo) && $settings->logo!='')
                <a href="" onclick="deleteImg(this)" type="logo" img_id="seo_img_logo">Delete</a>
              @endif
              </div>
            </div>
            <div>
              <span class="text-red">{{$errors->first('logo')}}</span>
              <p class="help-block">Allowed extensions: jpg, png, jpeg</p>
              @if(file_exists(PATH_UPLOAD.'/'.$settings->logo) && $settings->logo!='')
              <img src="{{'/'.PATH_UPLOAD.'/'.$settings->logo}}" class="img-responsive" id="seo_img_logo">
              @endif
            </div>
          </div>
          <div class="form-group">
            <label for="favicon">Favicon</label>
            <div style="height: 22px;">
              <div style="width: 50%;float: left;">
              <input type="file" name="favicon" id="favicon" value="{{Request::old('favicon',$settings->favicon)}}">
              </div>
              <div style="width: 50%;float: left;">
                @if(file_exists(PATH_UPLOAD.'/'.$settings->favicon) && $settings->favicon!='')
                  <a href="" onclick="deleteImg(this)" type="favicon" img_id="seo_img_favicon">Delete</a>
                @endif
              </div>
            </div>
            <div>
              <span class="text-red">{{$errors->first('favicon')}}</span>
              <p class="help-block">Allowed extensions: jpg, png, jpeg</p>
              @if(file_exists(PATH_UPLOAD.'/'.$settings->favicon) && $settings->favicon!='')
                <img src="{{'/'.PATH_UPLOAD.'/'.$settings->favicon}}" class="img-responsive" id="seo_img_favicon">
              @endif
            </div>
          </div>
          <div class="form-group">
                        <label for="code_before_head_tag">Código antes de cerrar la  etiqueta head</label>


                      <textarea class="form-control" name="code_before_head_tag" id="code_before_head_tag" rows="4" cols="50">
                      {{Request::old('code_before_head_tag',$settings->code_before_head_tag)}}
                      </textarea>
                       <label class="text-red">{{$errors->first('code_before_head_tag')}}</label>

          </div>
          <div class="form-group">
            <label for="before">Código antes de la etiqueta body</label>
            <input type="text" class="form-control" name="code_before_body_tag" id="code_before_body_tag" placeholder="" maxlength="100" value="{{Request::old('code_before_body_tag',$settings->code_before_body_tag)}}">
            <label class="text-red">{{$errors->first('code_before_body_tag')}}</label>
          </div>
          <?php if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) { ?>
          <div class="box-footer">
            <input type="hidden" name="id" value="{{$settings->id}}">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
          </div>
          <?php } ?>
        </div>
        <?php if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) { ?>
      </form>
        <?php }?>

    </div>
  </div>
  <script type="application/javascript">
    function deleteImg(that) {
        var img_id = $(that).attr('img_id');
        $('#'+ img_id).hide();
        $(that).parent().append("<input type='hidden' name='deleteImg[]' value='"+$(that).attr('type')+"'>");
        $(that).hide();
    }
  </script>
  @endsection