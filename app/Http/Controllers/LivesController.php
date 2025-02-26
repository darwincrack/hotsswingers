<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\CountryModel;
use App\Modules\Api\Models\TravelModel;
use DB;

class livesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
       // \App::setLocale(session('lang'));
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if (AppSession::isLogin()) {
             \App::setLocale(session('lang'));
                return view('home.lives');
        }
        else{
            return redirect('/');
        }

    }


    public function travel(Request $req)
    {
        if (AppSession::isLogin()) {
            \App::setLocale(session('lang'));
           $userData   = AppSession::getLoginData();
           $userid= $userData->id;


           $users = TravelModel::select("*")
             ->join('users as u', 'u.id', '=', 'travel.userid')
             ->where('u.id', $userid)
             ->where('travel.salida', '>=', DB::raw('curdate()'))
             ->get();
           $countmisviajes= $users->count();


          // $countmisviajes = "10";

            $countries = CountryModel::orderBy('name')->lists('name', 'id')->all();


            return view('travel.index', compact('countries', 'userid','countmisviajes'));

        }
        else{
            return redirect('/');
        }

    }


      public function prueba()
    {
        \App::setLocale(session('lang'));
        return view('home.prueba');
    }

      public function pruebados()
    {
        \App::setLocale(session('lang'));
        return view('home.pruebados');
    }
}
