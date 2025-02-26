<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\GalleryModel;
use App\Modules\Api\Models\VideoModel;
use App\Modules\Api\Models\AttachmentModel;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\CsvExport;
use Nayjest\Grids\Components\ExcelExport;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\Laravel5\Pager;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\ShowingRecords;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\SelectFilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use App\Modules\Api\Models\DocumentModel;
use App\Helpers\MediaHelper;
use DB;
use HTML;


class GalleryController extends Controller {

  /**
   * @param int $id model id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   * 
   */
  public function getVideoGallery($id) {
    //check login
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect::to('admin/login')->with('message', 'Inicie sesión con rol de administrador');
    }
    $model = UserModel::find($id);
    if (!$model) {
      return Back()->with('msgError', 'El modelo no existe.');
    }
    return view('Admin::admin_list_video_galleries')->with('user', $model);
  }

  /**
   * @param int $id model id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   * 
   */
  public function getImageGallery($id) {
    //check login
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('message', 'Inicie sesión con rol de administrador');
    }
    $model = UserModel::find($id);
    if (!$model) {
      return Back()->with('msgError', 'El modelo no existe.');
    }
    return view('Admin::admin_list_image_galleries')->with('user', $model);
  }

  /**
   * @param int $id model id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   * 
   */
  public function addVideoGallery($modelId) {
    //check login
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('message', 'Inicie sesión con rol de administrador');
    }
    $model = UserModel::find($modelId);
    if (!$model) {
      return Back()->with('msgError', 'El modelo no existe.');
    }
    return view('Admin::admin_add_gallery')->with('user', $model)->with('galleryType', 'video');
  }

  /**
   * @param int $id model id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   * 
   */
  public function addImageGallery($modelId) {
    //check login
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('message', 'Inicie sesión con rol de administrador');
    }
    $model = UserModel::find($modelId);
    if (!$model) {
      return Back()->with('msgError', 'El modelo no existe.');
    }
    return view('Admin::admin_add_gallery')->with('user', $model)->with('galleryType', 'image');
  }

  public function addImage($modelId) {
    //check login
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('message', 'Inicie sesión con rol de administrador');
    }
    $model = UserModel::find($modelId);
    if (!$model) {
      return Back()->with('msgError', 'El modelo no existe.');
    }
    return view('Admin::admin_add_image')->with('user', $model);
  }

  /**
   * return @gallery param
   * author: Phong Le <pt.hongphong@gmail.com>
   * * */
  public function getEditVideoGallery($id) {

    $gallery = GalleryModel::select('galleries.*', 'attachment.mediaMeta')
      ->where('galleries.id', $id)
      ->leftJoin('attachment', 'attachment.id', '=', 'galleries.previewImage')
      ->first();

    if ($gallery) {
      return view('Admin::admin_edit_gallery')->with('gallery', $gallery);
    } else {
      return Back()->with('msgError', 'La galería no existe.');
    }
  }

  /**
   * @param int $id gallery id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function getListVideos($id) {
    $gallery = GalleryModel::find($id);
    if (!$gallery) {
      return Back()->with('msgError', 'Galería no encontrada.');
    }
    return view('Admin::admin_list_videos')->with('gallery', $gallery);
  }

  /**
   * @param int $id gallery id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function getListImages($id) {
    $gallery = GalleryModel::find($id);
    if (!$gallery) {
      return Back()->with('msgError', 'Galería no encontrada.');
    }
    return view('Admin::admin_list_images')->with('gallery', $gallery);
  }

  /**
   * return @gallery param
   * author: Phong Le <pt.hongphong@gmail.com>
   * * */
  public function getEditImageGallery($id) {

    $gallery = GalleryModel::where('galleries.id', $id)
      ->where('type', GalleryModel::IMAGE)
      ->first();

    if ($gallery) {
      return view('Admin::admin_edit_gallery')->with('gallery', $gallery);
    } else {
      return Back()->with('msgError', 'Galería no encontrada.');
    }
  }

  /**edit image gallery
   * return @gallery param
   * author: Phong Le <pt.hongphong@gmail.com>
   * **/
  public function editImage($modelId, $galleryId) {
    $userData = AppSession::getLoginData();
    if ($userData) {
      $gallery = GalleryModel::where('id', $galleryId)
        ->where('ownerId', $modelId)
        ->first();

      if ($gallery) {
        $attachment = AttachmentModel::where('parent_id', $gallery->id)->first();
        return view('Admin::admin_edit_image')->with('gallery', $gallery)->with('attachment', $attachment)->with('modelId', $modelId);
      } else {
        return redirect('admin/manager/image-gallery/'.$modelId);
      }
    }
  }



  public function getGalleryList() {

 

      $query = GalleryModel::select('galleries.id', 'galleries.createdAt','galleries.name','u.username', 'galleries.slug', DB::raw("IF(galleries.price, galleries.price, 0) as galleryPrice"), 'galleries.type','galleries.estado')
        ->Join('users as u', 'u.id', '=', 'galleries.ownerId')
        ->where('galleries.type', GalleryModel::IMAGE)
        ->orderBy('galleries.id','desc');

    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('id')
        ->setPageSize(10)
        ->setColumns([
 
          (new FieldConfig)
          ->setName('id')
          ->setLabel('ID')
          ->setSortable(true)
          ->setSorting(Grid::SORT_ASC)
          ,

          (new FieldConfig)
          ->setName('name')
          ->setLabel('Nombre galería')
          ->setCallback(function ($val) {
              return "{$val}";
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),

          (new FieldConfig)
          ->setName('username')
          ->setLabel('Username')
          ->setCallback(function ($val) {
              return "{$val}";
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )

          ,
          (new FieldConfig)
          ->setName('galleryPrice')
          ->setLabel('Precio')
          ->setSortable(true)
          ,

          (new FieldConfig)
          ->setName('estado')
          ->setLabel('estado')
          ->setSortable(true)
          ->addFilter(
            (new SelectFilterConfig)
            ->setName('estado')
            ->setOptions(['0'=>'Pendiente de aprobación','1'=>'Aprobado','2'=>'No aprobado'])
          )
          ->setCallback(function($val){
              $return = '';
              switch ($val){
                  case 0: $return = 'Pendiente de aprobación';
                      break;
                  case 1: $return = 'Aprobado';
                      break;
                  case 2: $return = 'No aprobado';
                      break;
                  default: $return = '';
                      break;
              }
              return $return;
          }),





          (new FieldConfig)
          ->setName('createdAt')
          ->setLabel('Creado en')
          ->setSortable(true)
          ->setCallback(function($val){
            $d = new \DateTime($val);
            return $d->format('d/m/Y');
          })
          ,
          (new FieldConfig)
          ->setName('id')
          ->setLabel('Acciones')
          ->setCallback(function ($val, $row) {
              $item = $row->getSrc();
              $url = ""; 
              if($item->estado == 0 ){
                  $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/aprobar/gallery/' . $val)."' title='Aprobar Galería'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
                  $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/rechazar/gallery/' . $val) . "' title='No aprobar galeria o imagen' onclick=\"return confirm('¿Estás seguro de que quieres rechazar esta galería o imagen?')\"><span class='fa fa-ban'></span></a>";
              }
              if($item->estado == 1){
                  $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/rechazar/gallery/' . $val) . "' title='No aprobar galeria o imagen' onclick=\"return confirm('¿Estás seguro de que quieres rechazar esta galería o imagen?')\"><span class='fa fa-ban'></span></a>";
              }

                 if($item->estado == 2){
                   $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/aprobar/gallery/' . $val)."' title='Aprobar Galería'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
              }


              $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/media/image-gallery/' . $val) . "' title='Ver Galerías de imágenes' target='_blank'><span class='fa fa-picture-o'></span></a>";

              $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/image-gallery/edit/' . $val) . "' title='Editar galeria o imagen' ><span class='fa fa-pencil'></span></a>";

              return $url;

            })
          ->setSortable(false)
          ,
        ])
        ->setComponents([
          (new THead)
          ->setComponents([
            (new ColumnHeadersRow),
            (new FiltersRow)
            ,
            (new OneCellRow)
            ->setRenderSection(RenderableRegistry::SECTION_END)
            ->setComponents([
              (new RecordsPerPage)
              ->setVariants([
                10,
                20,
                30,
                40,
                50,
                100,
                200,
                300,
                400,
                500
              ]),
              new ColumnsHider,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('usuarios-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
              (new HtmlTag)
              ->setContent('<span class="glyphicon glyphicon-refresh"></span> Filtrar')
              ->setTagName('button')
              ->setRenderSection(RenderableRegistry::SECTION_END)
              ->setAttributes([
                'class' => 'btn btn-success btn-sm',
                'id' => 'formFilter'
              ])
            ])
          ])
          ,
          (new TFoot)
          ->setComponents([
            (new OneCellRow)
            ->setComponents([
              new Pager,
              (new HtmlTag)
              ->setAttributes(['class' => 'pull-right'])
              ->addComponent(new ShowingRecords)
              ,
            ])
          ])
        ])
    );
    $grid = $grid->render();

    return view('Admin::admin_aprobar_imagenes', compact('grid'));


  }



  public function aprobarGaleria($id) {
    $gallery = GalleryModel::find($id);



    $adminData = AppSession::getLoginData();
    if (!$gallery) {
      return Back()->with('msgError', 'Galería no existe!');
    }
    if(env('DISABLE_EDIT_ADMIN') && !$adminData->isSuperAdmin)
      return redirect('admin/manager/members')->with('msgError', '¡No se puede acceder a esta página!');
    if ($gallery->estado == 1) {
      return Back()->with('msgWarning', 'La galería ya ha sido aprobada');
    }


    $gallery->estado = 1;

    if ($gallery->save()) {

        $user = UserModel::find($gallery->ownerId);

        $username = $user->username;
        $email = $user->email;


                //send mail here
        $send = \Mail::send('email.aprobar_galeria', array('username' => $username, 'email' => $email, 'name_galeria' => $gallery->name, 'id_galeria' =>$id), function($message) use($email) {
            $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($email)->subject('Galería aprobada | '. app('settings')->siteName);
          });
        if ($send) {
          return Back()->with('msgInfo', '¡Se ha enviado un correo electrónico al usuario notificandole que la galería ha sido aprobada!');
        } else {
          return Back()->with('msgError', 'Error de correo enviado.');
        }


    }
    return Back()->with('msgError', 'System error.');
  }



  public function RechazarGaleria($id) {
   $gallery = GalleryModel::find($id);



    $adminData = AppSession::getLoginData();
    if (!$gallery) {
      return Back()->with('msgError', 'Galería no existe!');
    }
    if(env('DISABLE_EDIT_ADMIN') && !$adminData->isSuperAdmin)
      return redirect('admin/manager/members')->with('msgError', '¡No se puede acceder a esta página!');
    if ($gallery->estado == 2) {
      return Back()->with('msgWarning', 'La galería ya ha sido rechazada');
    }


    $gallery->estado = 2;

    if ($gallery->save()) {

        $user = UserModel::find($gallery->ownerId);

        $username = $user->username;
        $email = $user->email;


                //send mail here
        $send = \Mail::send('email.rechazar_galeria', array('username' => $username, 'email' => $email, 'name_galeria' => $gallery->name, 'id_galeria' =>$id), function($message) use($email) {
            $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($email)->subject('Galería no aprobada | '. app('settings')->siteName);
          });
        if ($send) {
          return Back()->with('msgInfo', '¡Se ha enviado un correo electrónico al usuario notificandole que la galería no ha sido aprobada!');
        } else {
          return Back()->with('msgError', 'Error de correo enviado.');
        }


    }
    return Back()->with('msgError', 'System error.');
  }






  public function getVideoList() {

    
      $query = VideoModel::select('videos.id','videos.createdAt', 'videos.title','u.username', 'videos.seo_url','videos.ownerId', 'videos.seo_url', DB::raw("IF(videos.price, videos.price, 0) as galleryPrice"), 'videos.status','videos.estado')
        ->Join('users as u', 'u.id', '=', 'videos.ownerId')
        ->orderBy('videos.id','desc');

    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('id')
        ->setPageSize(10)
        ->setColumns([
 
          (new FieldConfig)
          ->setName('id')
          ->setLabel('ID')
          ->setSortable(true)
          ->setSorting(Grid::SORT_ASC)
          ,

          (new FieldConfig)
          ->setName('title')
          ->setLabel('Nombre del video')
          ->setCallback(function ($val) {
              return "{$val}";
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),

          (new FieldConfig)
          ->setName('username')
          ->setLabel('Username')
          ->setCallback(function ($val) {
              return "{$val}";
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )

          ,
          (new FieldConfig)
          ->setName('galleryPrice')
          ->setLabel('Precio')
          ->setSortable(true)
          ,
          (new FieldConfig)
          ->setName('status')
          ->setLabel('Estatus del video')
          ->setSortable(true)
          ,

          (new FieldConfig)
          ->setName('estado')
          ->setLabel('estado')
          ->setSortable(true)
          ->addFilter(
            (new SelectFilterConfig)
            ->setName('estado')
            ->setOptions(['0'=>'Pendiente de aprobación','1'=>'Aprobado','2'=>'No aprobado'])
          )
          ->setCallback(function($val){
              $return = '';
              switch ($val){
                  case 0: $return = 'Pendiente de aprobación';
                      break;
                  case 1: $return = 'Aprobado';
                      break;
                  case 2: $return = 'No aprobado';
                      break;
                  default: $return = '';
                      break;
              }
              return $return;
          }),





          (new FieldConfig)
          ->setName('createdAt')
          ->setLabel('Creado en')
          ->setSortable(true)
          ->setCallback(function($val){
            $d = new \DateTime($val);
            return $d->format('d/m/Y');
          })
          ,
          (new FieldConfig)
          ->setName('id')
          ->setLabel('Acciones')
          ->setCallback(function ($val, $row) {
              $item = $row->getSrc();
              $url = ""; 
              if($item->estado == 0 ){
                  $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/aprobar/video/' . $val)."' title='Aprobar Video'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
                  $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/rechazar/video/' . $val) . "' title='Rechazar Video' onclick=\"return confirm('¿Estás seguro de que quieres rechazar este video?')\"><span class='fa fa-ban'></span></a>";
              }
              if($item->estado == 1){
                  $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/rechazar/video/' . $val) . "' title='Rechazar video' onclick=\"return confirm('¿Estás seguro de que quieres rechazar este video?')\"><span class='fa fa-ban'></span></a>";
              }

                 if($item->estado == 2){
                   $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/aprobar/video/' . $val)."' title='Aprobar Video'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
              }


              $url .= "&nbsp;&nbsp;<a href='" . URL('media/video/watch/' . $item->seo_url) . "' title='Ver video' target='_blank'><span class='fa fa-picture-o'></span></a>";

              $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/media/video-gallery/'.$item->ownerId.'/edit-video/' . $val) . "' title='Editar video' ><span class='fa fa-pencil'></span></a>";

              return $url;

            })
          ->setSortable(false)
          ,
        ])
        ->setComponents([
          (new THead)
          ->setComponents([
            (new ColumnHeadersRow),
            (new FiltersRow)
            ,
            (new OneCellRow)
            ->setRenderSection(RenderableRegistry::SECTION_END)
            ->setComponents([
              (new RecordsPerPage)
              ->setVariants([
                10,
                20,
                30,
                40,
                50,
                100,
                200,
                300,
                400,
                500
              ]),
              new ColumnsHider,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('usuarios-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
              (new HtmlTag)
              ->setContent('<span class="glyphicon glyphicon-refresh"></span> Filtrar')
              ->setTagName('button')
              ->setRenderSection(RenderableRegistry::SECTION_END)
              ->setAttributes([
                'class' => 'btn btn-success btn-sm',
                'id' => 'formFilter'
              ])
            ])
          ])
          ,
          (new TFoot)
          ->setComponents([
            (new OneCellRow)
            ->setComponents([
              new Pager,
              (new HtmlTag)
              ->setAttributes(['class' => 'pull-right'])
              ->addComponent(new ShowingRecords)
              ,
            ])
          ])
        ])
    );
    $grid = $grid->render();

    return view('Admin::admin_aprobar_videos', compact('grid'));

  }


  public function aprobarVideo($id) {
    $video = VideoModel::find($id);



    $adminData = AppSession::getLoginData();
    if (!$video) {
      return Back()->with('msgError', 'Video no existe!');
    }
    if(env('DISABLE_EDIT_ADMIN') && !$adminData->isSuperAdmin)
      return redirect('admin/manager/members')->with('msgError', '¡No se puede acceder a esta página!');
    if ($video->estado == 1) {
      return Back()->with('msgWarning', 'El video ya ha sido aprobado');
    }


    $video->estado = 1;

    if ($video->save()) {

        $user = UserModel::find($video->ownerId);

        $username = $user->username;
        $email = $user->email;


                //send mail here
        $send = \Mail::send('email.aprobar_video', array('username' => $username, 'email' => $email, 'name_video' => $video->title, 'id_video' =>$id), function($message) use($email) {
            $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($email)->subject('Video aprobado | '. app('settings')->siteName);
          });
        if ($send) {
          return Back()->with('msgInfo', '¡Se ha enviado un correo electrónico al usuario notificandole que el video ha sido aprobado!');
        } else {
          return Back()->with('msgError', 'Error de correo enviado.');
        }


    }
    return Back()->with('msgError', 'System error.');
  }


    public function RechazarVideo($id) {
    $video = VideoModel::find($id);



    $adminData = AppSession::getLoginData();
    if (!$video) {
      return Back()->with('msgError', 'Video no existe!');
    }
    if(env('DISABLE_EDIT_ADMIN') && !$adminData->isSuperAdmin)
      return redirect('admin/manager/members')->with('msgError', '¡No se puede acceder a esta página!');
    if ($video->estado == 2) {
      return Back()->with('msgWarning', 'El video no ya ha sido aprobado');
    }


    $video->estado = 2;

    if ($video->save()) {

        $user = UserModel::find($video->ownerId);

        $username = $user->username;
        $email = $user->email;


                //send mail here
            $send = \Mail::send('email.rechazar_video', array('username' => $username, 'email' => $email, 'name_video' => $video->title, 'id_video' =>$id), function($message) use($email) {
            $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($email)->subject('Video no aprobado | '. app('settings')->siteName);
          });
        if ($send) {
          return Back()->with('msgInfo', '¡Se ha enviado un correo electrónico al usuario notificandole que el video no ha sido aprobado!');
        } else {
          return Back()->with('msgError', 'Error de correo enviado.');
        }


    }
    return Back()->with('msgError', 'System error.');
  }


}
