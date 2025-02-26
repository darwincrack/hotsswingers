@extends('admin-back-end')
@section('title', 'Mi perfil')
@section('content')

<div class="row">
  <div class="col-md-3">

    <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        <h3 class="profile-username text-center">{{$profile->username}}</h3>

        <p class="text-muted text-center">Web Admin</p>
      </div>
      <!-- /.box-body -->
    </div>
  </div>
  <!-- /.box -->
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Configuraciones</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="settings">
          <form class="form-horizontal" method="post" role="form" action="">
            <div class="form-group">
              <label for="username" class="col-sm-3 control-label">nombre de usuario</label>

              <div class="col-sm-9">
                <input type="text" class="form-control" disabled="disabled" id="username" placeholder="" name="username" value="{{$profile->username}}">
              </div>
            </div>
            <div class="form-group required">
              <label for="firstName" class="col-sm-3 control-label">Nombre </label>

              <div class="col-sm-9">
                <input type="text" class="form-control" id="firstName" placeholder="" name="firstName" value="{{old('firstName', $profile->firstName)}}">
                <span class="text-red">{{$errors->first('firstName')}}</span>
              </div>
            </div>
            <div class="form-group required">
              <label for="lastName" class="col-sm-3 control-label">Apellido </label>

              <div class="col-sm-9">
                <input type="text" name="lastName" id="lastName" class="form-control" value="{{old('lastName', $profile->lastName)}}">
                <span class="text-red">{{$errors->first('lastName')}}</span>
              </div>
            </div>
            <div class="form-group required">
              <label for="email" class="col-sm-3 control-label">Email </label>

              <div class="col-sm-9">
                <input type="email" class="form-control" id="email" placeholder="" name="email" value="{{old('email', $profile->email)}}">
                <span class="text-red">{{$errors->first('email')}}</span>
              </div>
            </div>
            
            <div class="form-group required">
              <label for="password" class="col-sm-3 control-label">Contraseña </label>

              <div class="col-sm-9">
                <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}">
                <span class="text-red">{{$errors->first('password')}}</span>
              </div>
            </div>
            <div class="form-group">
              <label for="newPassword" class="col-sm-3 control-label">Nueva contraseña</label>

              <div class="col-sm-9">
                <input type="password" class="form-control" id="newPassword" name="newPassword" value="{{old('newPassword')}}">
                <span class="text-red">{{$errors->first('newPassword')}}</span>
              </div>
            </div>
            <div class="form-group">
              <label for="confirmNewPassword" class="col-sm-3 control-label">Confirmar nueva contraseña</label>

              <div class="col-sm-9">
                <input type="password" class="form-control" id="newPassword_confirmation" name="newPassword_confirmation" value="{{old('newPassword_confirmation')}}">
                <span class="text-red">{{$errors->first('newPassword_confirmation')}}</span>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-danger">Guardar cambios</button>
              </div>
            </div>
          </form>
        </div>
        <!-- /.tab-pane -->
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- /.nav-tabs-custom -->
  </div>
</div>

@endsection
