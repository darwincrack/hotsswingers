<?php

namespace App\Http\Controllers;

use App\Modules\Api\Models\PageModel;

class PageController extends Controller {
  /**
   * view page detail
   * 
   */


  
  public function view(PageModel $page){
  	  \App::setLocale(session('lang'));
    return view('page.default', compact('page'));
  }

    public function viewdos($idioma ,PageModel $page){
  	  \App::setLocale(session('lang'));
    return view('page.default', compact('page'));
  }
}
