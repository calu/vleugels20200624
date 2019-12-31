<?php
use Illuminate\Http\Request;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', function(){
   // Hier mag je maar komen als je aangemeld bent
   if (Auth::guest()) abort(403); 
   // Maak nu het onderscheid tussen admin en klant
   if (Auth::user()->admin == 0){
       // een klant
       //   .. TODO : haal de klant_id op
       // en return naar ClientController@show -- toon de splash van de klant
         $client = Auth::user()->client()->first();        
         return redirect()->action('ClientController@show',['id' => $client->id]);   
   } else
        return view('adminhome'); // toon de splashscreen voor de admin
});

/* Contactpersoon */
Route::get('contactpersonen/{id}/destroy', 'ContactpersoonController@destroy');
Route::resource('contactpersonen', 'ContactpersoonController');

/* mutualiteiten */
Route::get('mutualiteiten/{id}/destroy', 'MutualiteitController@destroy');
Route::resource('mutualiteiten', 'MutualiteitController');

/* codes */
Route::get('codes/{id}/destroy', 'CodeController@destroy');
Route::resource('codes', 'CodeController');

/** Clients **/
Route::get('clients/{id}/createWithId', 'ClientController@createWithId');
Route::get('clients/{id}/showAsAdmin', 'ClientController@showAsAdmin');
Route::get('clients/{id}/showAsAdminBis', 'ClientController@showAsAdminBis');
Route::get('clients/{id}/aanmelden', 'ClientController@aanmelden');
Route::get('clients/{id}/afmelden', 'ClientController@afmelden');
Route::get('clients/{id}/hotelcreate', 'ClientController@hotelcreate');
Route::get('clients/{id}/calendar', 'ClientController@calendar');
Route::resource('clients', 'ClientController');

/** Kamers **/
Route::get('kamers/visualindex', 'KamerController@visualindex');
Route::get('kamers/{id}/destroy', 'KamerController@destroy');
Route::resource('kamers', 'KamerController');

/** Hotels **/
// Route::post('hotels/reserveer', 'HotelController@reserveer'); 
Route::post('hotels/reserveer', 'HotelController@reserveer');
Route::resource('hotels', 'HotelController');

/** FileUpload **/
Route::post('/upload', function (Request $request) {
 //   dd($request->all());
    $validator = Validator::make($request->all(), [
        'image' => 'required|image64:jpeg,jpg,png'
    ]);
    if ($validator->fails()) {
        return response()->json(['errors'=>$validator->errors()]);
    } else {
        $imageData = $request->get('image');
        $fileName = $request->get('name');
 //       $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
        Image::make($request->get('image'))->save(public_path('img/hotelkamers/').$fileName);
//        Image::make($request->get('image'))->save(public_path('images/').$fileName);

        return response()->json(['error'=>false]);
    }
}); 

/** Calendar **/
Route::resource('calendars', 'CalendarController');

/** boekhouding **/
Route::get('boekhouding', 'BoekhoudingController@index');
Route::get('boekhouding/{id}/{type}/detail', 'BoekhoudingController@detail');
Route::post('boekhouding/bedrag', 'BoekhoudingController@store');
Route::post('boekhouding/factuur', 'BoekhoudingController@factuur');
Route::get('boekhouding/verzonden', 'BoekhoudingController@verzonden');

/** pdf **/
Route::get('pdf/generatePDF', 'PdfController@generatePDF');