<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use App\Maintenance;
use App\User;

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/email', function(){
});

//Announcements
Route::get('/announcement/display', 'AnnouncementController@index');

Route::get('/announcement/form', 'AnnouncementController@create');

Route::post('/announcement/display', 'AnnouncementController@publish');

Route::get('/announcement/{announcement}/edit', 'AnnouncementController@edit');

Route::patch('/announcement/{announcement}', 'AnnouncementController@update');

Route::get('/announcement/{announcement}/delete', 'AnnouncementController@delete');

//Maintenance
Route::get('/maintenance/form', 'MaintenanceController@create');

Route::get('/maintenance/display', 'MaintenanceController@index');

Route::get('/maintenance/{report}','MaintenanceController@index1');

Route::patch('/maintenance/display', 'MaintenanceController@update');

Route::post('/maintenance/received', 'MaintenanceController@publish');

Route::get('/maintenance/display/{report}', 'MaintenanceController@show');

Route::any('/search',function(){
    $q = Input::get ( 'q' );
    $results = Maintenance::where('title','LIKE','%'.$q.'%')->orWhere('status','LIKE','%'.$q.'%')->get();
    if(count($results) > 0){
    	foreach($results as $result){
    		$id = $result-> user_id;
    		$user = User::find($id);
        	$result->username = $user-> name;
        	$result->currentRoom = $user-> currentRoom;
    	}
        return view('/maintenance/results',compact('results'));
    }
    else{
        $reports = Maintenance::all()->sortByDesc('created_at');
        foreach($reports as $report){
            $id = $report-> user_id;
            $user = User::find($id);
            $report->username = $user-> name;
            $report->currentRoom = $user-> currentRoom;

        }
        \Session::flash('message', 'No details found! Please try searching again using the title or status of the report');
    	return view('/maintenance/display',compact('reports'));
    }
});

//Commments

Route::post('/maintenance/display/{report}', 'CommentsController@store');


//RoomDraw
Route::get('/roomdraw', 'RoomDrawController@index');

Route::post('/roomdraw', 'RoomDrawController@bid');


//Import & Export Excel
Route::get('importExport','ExcelController@importExport');

Route::get('downloadExcel/{type}','ExcelController@downloadExcel');

Route::post('importExcel', 'ExcelController@importExcel');