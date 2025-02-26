<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\Gustos;
use App\Modules\Api\Models\Preferencias;
use App\Modules\Api\Models\CountryModel;
use Illuminate\Http\Request;
use App;
use Config;

class Controller extends BaseController {

  use AuthorizesRequests,
      DispatchesJobs,
      ValidatesRequests;

  public function index(Request $req) {

       session_start();

       $_SESSION['LANG'] =  'es';
      
 \App::setLocale(Config('app.locale'));

    session(['lang' => Config('app.locale')]);
       
 
      $userData = AppSession::getLoginData();

      if(\App::environment('development') && !$userData){
          return view('home.underconstruction');
      }
      
      if($userData){

      /*   print_r($userData);

       die("sfds");*/
       return redirect("dashboard");


      }
      else{

      $type = ($req->has('type')) ? $req->get('type') : '';
        
        $countries = CountryModel::orderBy('name')->lists('name', 'id');
            
        $gustosES = Gustos::orderBy('descripcionES')->lists('descripcionES', 'gustos_id');
        $gustosEN = Gustos::orderBy('descripcionEN')->lists('descripcionEN', 'gustos_id');
        $gustosFR = Gustos::orderBy('descripcionFR')->lists('descripcionFR', 'gustos_id');

        $gustos['ES'] = $gustosES;
        $gustos['EN'] = $gustosEN;
        $gustos['FR'] = $gustosFR;
            
        $PreferenciasES = Preferencias::orderBy('Preferencias_id')->lists('descripcionES', 'Preferencias_id');
        $PreferenciasEN = Preferencias::orderBy('Preferencias_id')->lists('descripcionEN', 'Preferencias_id');
        $PreferenciasFR = Preferencias::orderBy('Preferencias_id')->lists('descripcionFR', 'Preferencias_id');


        $Preferencias['ES'] = $PreferenciasES;
        $Preferencias['EN'] = $PreferenciasEN;
        $Preferencias['FR'] = $PreferenciasFR;


        return view('home.index', compact('type', 'countries','gustos','Preferencias'));

       
      }
      

  }


    public function en(Request $req) {

       session_start();

       $_SESSION['LANG'] =  'en';

  session(['lang' => 'en']);

      \App::setLocale('en');
    

      $userData = AppSession::getLoginData();

      if(\App::environment('development') && !$userData){
          return view('home.underconstruction');
      }
      
      if($userData){
       return redirect("dashboardwww");
      }
      else{

      $type = ($req->has('type')) ? $req->get('type') : '';
        
        $countries = CountryModel::orderBy('name')->lists('name', 'id');
            
        $gustosES = Gustos::orderBy('descripcionES')->lists('descripcionES', 'gustos_id');
        $gustosEN = Gustos::orderBy('descripcionEN')->lists('descripcionEN', 'gustos_id');
        $gustosFR = Gustos::orderBy('descripcionFR')->lists('descripcionFR', 'gustos_id');

        $gustos['ES'] = $gustosES;
        $gustos['EN'] = $gustosEN;
        $gustos['FR'] = $gustosFR;
            
        $PreferenciasES = Preferencias::orderBy('Preferencias_id')->lists('descripcionES', 'Preferencias_id');
        $PreferenciasEN = Preferencias::orderBy('Preferencias_id')->lists('descripcionEN', 'Preferencias_id');
        $PreferenciasFR = Preferencias::orderBy('Preferencias_id')->lists('descripcionFR', 'Preferencias_id');


        $Preferencias['ES'] = $PreferenciasES;
        $Preferencias['EN'] = $PreferenciasEN;
        $Preferencias['FR'] = $PreferenciasFR;


        return view('home.en', compact('type', 'countries','gustos','Preferencias'));


       
      }

    }

  


  public function fr(Request $req) {

      session_start();

       $_SESSION['LANG'] =  'fr';
      \App::setLocale('fr');
      session(['lang' => 'fr']);

      $userData = AppSession::getLoginData();

      if(\App::environment('development') && !$userData){
          return view('home.underconstruction');
      }
      
      if($userData){
       return redirect("dashboardxxx");
      }
      else{

      $type = ($req->has('type')) ? $req->get('type') : '';
        
        $countries = CountryModel::orderBy('name')->lists('name', 'id');
            
        $gustosES = Gustos::orderBy('descripcionES')->lists('descripcionES', 'gustos_id');
        $gustosEN = Gustos::orderBy('descripcionEN')->lists('descripcionEN', 'gustos_id');
        $gustosFR = Gustos::orderBy('descripcionFR')->lists('descripcionFR', 'gustos_id');

        $gustos['ES'] = $gustosES;
        $gustos['EN'] = $gustosEN;
        $gustos['FR'] = $gustosFR;
            
        $PreferenciasES = Preferencias::orderBy('Preferencias_id')->lists('descripcionES', 'Preferencias_id');
        $PreferenciasEN = Preferencias::orderBy('Preferencias_id')->lists('descripcionEN', 'Preferencias_id');
        $PreferenciasFR = Preferencias::orderBy('Preferencias_id')->lists('descripcionFR', 'Preferencias_id');


        $Preferencias['ES'] = $PreferenciasES;
        $Preferencias['EN'] = $PreferenciasEN;
        $Preferencias['FR'] = $PreferenciasFR;


        return view('home.fr', compact('type', 'countries','gustos','Preferencias'));
 
      }

    }

      public function es(Request $req) {

          \App::setLocale('es');
          return redirect('/');


      }

}