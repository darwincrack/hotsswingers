<?php

use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

$userLogin = AppSession::getLoginData();
?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ AppHelper::getMyProfileAvatar() }}" class="img-circle" alt="User Image" />
      </div>
      <div class="pull-left info">
        <p>{{$userLogin->username}}</p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i>@lang('messages.online')</a>
      </div>
    </div>

    <!-- search form (Optional) -->
<!--    <form action="" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search..." value="{{Request::get('q')}}"/>
        <span class="input-group-btn">
          <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>   
    </form>-->
    <!-- /.search form -->

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">Header</li>
      <!-- Optionally, you can add icons to the links -->
      <li class="{{Request::is('*/profile') ? 'active' : ''}}"><a href="{{URL('admin/manager/profile')}}"><i class="fa fa-user"></i> <span>Perfil</span></a>
      </li>
      <li class="treeview {{Request::is('*/manager/member*') ? 'active': ''}}"><a href="#"><i class="fa fa-users"></i> <span>Admin. usuarios de sistema  </span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/members') ? 'active': ''}}"><a href="{{URL('admin/manager/members')}}"> Lista de usuarios </a></li>
          <?php if(!env('DISABLE_EDIT_ADMIN') || $userLogin->isSuperAdmin) {?>
          <li class="{{Request::is('*/member/add') ? 'active': ''}}"><a href="{{URL('admin/manager/member/add')}}"> Añadir miembro</a></li>
          <?php }?>
          <li class="{{Request::is('*/members/transactions') ? 'active': ''}}"><a href="{{URL('admin/manager/members/transactions')}}">transcciones</a></li>
        </ul>
      </li>
      <li class="treeview {{(Request::is('*/manager/performers*') && !Request::is('*/performerstudios*') || Request::is('*/manager/model/*')) ? 'active': '' }}"><a href="#"><i class="fa fa-users"></i> <span>Administrar usuarios</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/performers') ? 'active': ''}}"><a href="{{URL('admin/manager/performers')}}">Lista de usuarios</a></li>
          <li class="{{Request::is('*/manager/performers/online') ? 'active': ''}}"><a href="{{URL('admin/manager/performers/online')}}">Usuarios online</a></li>
          <?php if(!env('DISABLE_EDIT_ADMIN') || $userLogin->isSuperAdmin) {?>
          <li class="{{Request::is('*/model/add') ? 'active': ''}}"><a href="{{URL('admin/manager/model/add')}}">Agregar usuario</a></li>
          <?php } ?>
          <li class="{{Request::is('*/manager/performers-pending') ? 'active': ''}}"><a href="{{URL('admin/manager/performers-pending')}}">Usuarios pendientes</a></li>
        </ul>
      </li>
    <!--  <li class="treeview {{(Request::is('*/manager/performerstudios*') || Request::is('*/manager/studio/*') || Request::is('*/studio-profile/*')) ? 'active': ''}}"><a href="#"><i class="fa fa-suitcase"></i> <span>Admin. prop. de estudios</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/performerstudios') ? 'active': ''}}"><a href="{{URL('admin/manager/performerstudios')}}"> Lista dueños de estudio</a></li>
          <?php if(!env('DISABLE_EDIT_ADMIN') || $userLogin->isSuperAdmin) {?>
          <li class="{{Request::is('*/studio/add') ? 'active': ''}}"><a href="{{URL('admin/manager/studio/add')}}">@lang('messages.addstudio')</a></li>
          <?php }?>
          <li class="{{Request::is('*/performerstudios-pending') ? 'active': ''}}"><a href="{{URL('admin/manager/performerstudios-pending')}}">@lang('messages.pendingstudios')</a></li>
        </ul>
      </li> -->
      <li class="treeview {{(Request::is('*/stats/*')) ? 'active': ''}}"><a href="#"><i class="fa fa-line-chart"></i> <span>estadisticas</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/stats/performer') ? 'active': ''}}"><a href="{{URL('admin/stats/performer')}}">usuarios</a></li>
          <!--<li class="{{Request::is('*/stats/studio') || Request::is('*/stats/studio-model*') ? 'active': ''}}"><a href="{{URL('admin/stats/studio')}}">@lang('messages.studio')</a></li> -->
        </ul>
      </li>
     <li class="{{Request::is('*/performercategories') ? 'active' : ''}}"><a href="{{URL('admin/manager/performercategories')}}"><i class="fa fa-server"></i> <span>Gestionar categorías </span></a></li>
      <li class="treeview {{Request::is('*/payments/*') ? 'active' : ''}}"><a href="#"><i class="fa fa-credit-card"></i> <span>Gestionar transacciones</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/payments/videos') ? 'active' : ''}}"><a href="{{URL('admin/manager/payments/videos')}}">Venta de videos</a></li>
          <li class="{{Request::is('*/payments/galleries') ? 'active' : ''}}"><a href="{{URL('admin/manager/payments/galleries')}}">Venta de imágenes</a></li>
          <li class="{{Request::is('*/payments/others') ? 'active' : ''}}"><a href="{{URL('admin/manager/payments/others')}}">Propinas y Privado / Grupo</a></li>
          <li class="{{Request::is('*/payments/products') ? 'active' : ''}}"><a href="{{URL('admin/manager/payments/products')}}">Venta de productos fisicos</a></li>
        </ul>
      </li>
      <li class="treeview {{Request::is('*/requestpayout/*') ? 'active' : ''}}">
        <a href="#"><i class="fa fa-usd"></i> <span>Solicitud de Pago</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/requestpayout/performers/listing') ? 'active' : ''}}">
            <a href="{{URL('admin/requestpayout/performers/listing')}}">Lista de solicitudes de usuarios</a>
          </li>
         <!-- <li class="{{Request::is('*/requestpayout/studios/listing') ? 'active' : ''}}">
            <a href="{{URL('admin/requestpayout/studios/listing')}}">@lang('messages.listallstudiorequests')</a>
          </li> -->
        </ul>
      </li>
      <li class="treeview {{Request::is('*/commission/*') ? 'active' : ''}}">
        <a href="#"><i class="fa fa-database"></i> <span> Gestión de comisiones</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/commission/model') ? 'active' : ''}}">
            <a href="{{URL('admin/manager/commission/model')}}">usuario %</a>
          </li>
          <!--<li class="{{Request::is('*/commission/studio') ? 'active' : ''}}">
            <a href="{{URL('admin/manager/commission/studio')}}">  Estudio %</a>
          </li> -->
        </ul>
      </li>

      <li class="treeview {{Request::is('*/premios/*') ? 'active' : ''}}">
        <a href="#"><i class="fa fa-star"></i> <span> Premios</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{Request::is('*/premios/model') ? 'active' : ''}}">
            <a href="{{URL('admin/manager/premios/model')}}">Ganadores por conexiones</a>
          </li>

          <li class="{{Request::is('*/premios/ganadorestokens') ? 'active' : ''}}">
            <a href="{{URL('admin/manager/premios/ganadorestokens')}}">Ganadores por tokens</a>
          </li>

           <li class="{{Request::is('*/premios/tokens') ? 'active' : ''}}">
            <a href="{{URL('admin/manager/premios/tokens')}}">Asignar premios por tokens</a>
          </li>

           <li class="{{Request::is('*/premios/likes') ? 'active' : ''}}">
            <a href="{{URL('admin/manager/premios/likes')}}">Asignar premios por likes</a>
          </li>
          
        </ul>
      </li>

      <li class="{{(Request::is('*/paymentsystems')) ? 'active' : ''}}"><a href="{{URL('admin/manager/paymentsystems')}}"><i class="fa fa-paypal"></i> <span>Config. pasarela de pago  </span></a></li>
      <li class="{{(Request::is('*/settings')) ? 'active' : ''}}"><a href="{{URL('admin/dashboard/settings')}}"><i class="fa fa-wrench"></i> <span>Configuraciones  </span></a>
      <li class="{{(Request::is('*/settings/seo')) ? 'active' : ''}}"><a href="{{URL('admin/dashboard/settings/seo')}}"><i class="fa fa-wrench"></i> <span>SEO </span></a>
      </li>
     


     <li class="treeview {{(Request::is('*/pages') || Request::is('*/page') || Request::is('*/email-templates')) ? 'active': ''}}"><a href="#"><i class="fa fa-users"></i> <span>Gestor de contenidos</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{(Request::is('*/pages') || Request::is('*/page')) ? 'active': ''}}"><a href="{{URL('admin/pages')}}">Páginas</a></li>
          
        </ul>
      </li>


     <li class="{{(Request::is('*/conversaciones')) ? 'active' : ''}}"><a href="{{URL('admin/manager/conversaciones')}}"><i class="fa fa-comment"></i> <span>Conversaciones  </span></a>
      </li>


           <li class="treeview {{(Request::is('*/aprobar/*')) ? 'active': ''}}"><a href="#"><i class="fa fa-film"></i> <span>Aprobar Multimedia</span>  <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{(Request::is('*/aprobar/gallery/list')) ? 'active': ''}}"><a href="{{URL('admin/manager/aprobar/gallery/list')}}">Imagenes</a></li>
            <li class="{{(Request::is('admin/manager/aprobar/video/list')) ? 'active': ''}}"><a href="{{URL('admin/manager/aprobar/video/list')}}">Videos</a></li>
          
        </ul>
      </li>


      <li class="{{(Request::is('*/Social-network')) ? 'active' : ''}}"><a href="{{URL('dashboard/administrator')}}"><i class="fa fa-wrench"></i> <span>Configuraciones red social  </span></a>
      </li>

        <li class=""><a href="{{URL('blog/wp-admin')}}" target="_blank"><i class="fa fa-wrench"></i> <span>Admin Blog  </span></a>
      </li>
    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>