<?php




/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//require $_SERVER['DOCUMENT_ROOT'].'/public/define.php';

Route::get('/','Auth\AuthController@index');


Route::get('en/','Controller@en');

Route::get('es/','Controller@es');

Route::get('fr/','Controller@fr');


Route::get('lives','LivesController@index');


Route::get('travel','LivesController@travel');

Route::get('/runcomisiones' , function(){
    Artisan::call('schedule:run');
    return 'OK';
});


Route::get("/livesmin", function(){
   return View::make("home.livesmin");
});

Route::get("/livesHome", function(){
    \App::setLocale(session('lang'));
   return View::make("home.livesHome");
});

Route::get("/footerframe", function(){
   return View::make("widgets.footer");
});


Route::get('prueba','livesController@prueba');
Route::get('pruebados','livesController@pruebados');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::get('pag/{page}', 'PageController@view');
Route::get('{idioma}/pag/{page}', 'PageController@viewdos');
Route::get('media/{type}/{id}', 'MediaController@show');
Route::get('image/{id}/{year}/{month}/{day}/{slug}', [
    'as'        => 'images.show',
    'uses'  => 'ImagesController@show'
]);
Route::get('image/{id}', [
    'as'        => 'images.showById',
    'uses'  => 'ImagesController@showById'
]);



Route::get('/clear-cache', function() {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    return "Cache is cleared";
});




Route::group(['middleware' => ['web']], function () {
 
 //session_start();
 
       
 
    Route::get('lang/{lang}', function ($lang) {
        session(['lang' => $lang]);
        $_SESSION['LANG'] =  $lang;
        \App::setLocale(session('lang'));
        return redirect()->back()->withInput();


    })->where([
        'lang' => 'en|es|fr'
    ]);
 
});
