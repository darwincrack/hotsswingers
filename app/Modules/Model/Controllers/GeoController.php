<?php

  namespace App\Modules\Model\Controllers;

  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;
  use App\Helpers\Session as AppSession;
//use PulkitJalan\GeoIP\GeoIP;
  use App\Modules\Member\Models\CountriesModel;
  use App\Modules\Member\Models\PaisesModel;
  use Illuminate\Support\Facades\Input;
  use App\Modules\Api\Models\GeoBlockingModel;
  use DB;
  use Illuminate\Support\Facades\Validator;
  use Response;

  class GeoController extends Controller {

      /**
       * action get all blocking location
       */
      public function index(Request $req) {
          //check if is login and is model

        \App::setLocale(session('lang'));
          $userData = AppSession::getLoginData();
          if (!$userData) {
              return redirect::to('login')->with('message', trans('messages.pleaseLogin'));
          }
          if ($userData->role == 'model') {

              $geoblocking = GeoBlockingModel::select('geo_blockings.id','geo_blockings.city_name','i.country_name','i.region_name')
              ->where('userId', $userData->id)
              ->join('ip2location_db3 as i', 'geo_blockings.iso_code', '=', 'i.country_code')
              ->where('isBlock',1)
              ->groupBy('geo_blockings.id')
              ->get();


              $paises = PaisesModel::select('country_code', 'country_name')
                      ->where('country_name', '<>', '-')
                      ->orderBy('country_name')
                      ->distinct()
                      ->get();

            /*  $countries = CountriesModel::select('id', 'name', 'alpha_2 as code', DB::raw('(select IF(g.isBlock <> 1, false, true)  from geo_blockings as g where lower(g.iso_code)=lower(countries.alpha_2) && g.userId=' . $userData->id . ' limit 1) as block'))
                      ->orderBy('name')
                      ->get();*/
              return view("Model::geo-blocking", [
                  'userData' => $userData,
                 /* 'countries' => $countries,*/
                  'paises' => $paises,
                  'geoblockings' => $geoblocking
              ]);
          } else {
              return redirect::to('/');
          }
      }

      /**
       * Update the specified resource in storage.
       *
       * @param  int  $id
       * @return Response
       */
      public function update() {
          //
          $userData = AppSession::getLoginData();

          $nonBlock = GeoBlockingModel::where('userId', $userData->id);
          if (Input::has('countries')) {
              $nonBlock = $nonBlock->whereNotIn('iso_code', Input::get('countries'));
              foreach (Input::get('countries') as $country) {

                  $geo = GeoBlockingModel::firstOrNew(array('iso_code' => $country, 'userId' => $userData->id));
                  $geo->isBlock = true;
                  $geo->save();
              }
          }
          $nonBlock = $nonBlock->update(['isBlock' => false]);

          return back()->with('msgInfo', trans('messages.updateGeoSuccessful'));
      }


  public function countryCode($countrCode) {
        

        $data = PaisesModel::select('country_code', 'country_name', 'region_name', 'city_name')
                      ->where('country_name', '<>', '-')
                      ->where('city_name', '<>', '-')
                      ->where('country_code', $countrCode)
                      ->orderBy('city_name')
                      ->distinct('city_name')

                      ->get();

           return  $data;
  }


   public function store(Request $req) {

    \App::setLocale(session('lang'));
          $userData = AppSession::getLoginData();
          if (!$userData) {
              return redirect::to('login')->with('message', trans('messages.pleaseLogin'));
          }



      $validator = Validator::make($req->all(), [
            'pais' => 'required',
        ]);

        $input = $req->all();

        if ($validator->passes()) {




            $geo = new GeoBlockingModel;
            $geo->iso_code = $req->input('pais');
            $geo->isBlock = 1;

            if ($req->input('ciudad')!="0"){
                $geo->city_name= $req->input('ciudad');
            }
           
            $geo->userId= $userData->id;


            if ($geo->save()) { 

              $data = GeoBlockingModel::select('geo_blockings.id','geo_blockings.city_name','i.country_name','i.region_name')
              ->where('userId', $userData->id)
              ->join('ip2location_db3 as i', 'geo_blockings.iso_code', '=', 'i.country_code')
              ->where('isBlock',1)
              ->groupBy('geo_blockings.id')
              ->get();

                 return Response()->json(array('success' => true, 'message' =>'Guardado con éxito','data' => $data ));



            }else{

                return Response()->json(array('success' => false, 'data' => $data, 'message' =>'Ocurrio un error' ));

            }





        }


        return Response::json(['errors' => $validator->errors()]);


      
      




     

   }



  public function remove($idGeoBlocking) {

     $geo = GeoBlockingModel::where('id', $idGeoBlocking);

     if ($geo->delete()) { 

           return Response()->json(array('success' => true, 'message' =>'Eliiminado con éxito' ));

     }else{

          return Response()->json(array('success' => false, 'message' =>'Ocurrio un error' ));
     }

           
  }









  }
  