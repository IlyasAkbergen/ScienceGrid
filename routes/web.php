<?php
use App\Project;
use Illuminate\Http\Request;
// Route::get('/', function () {

// 	$projects = DB::table('projects')->get();
//     return view('welcome', compact('projects') );
// });


// Route::controllers([
// 	'auth' => 'Auth\AuthController',
// 	'password' => 'Auth\PasswordController',
// ]);



Route::get('/', 'ProjectsController@projects');

Route::post('/project', 'ProjectsController@create');

Route::get('/show/{id}', 'ProjectsController@show')->name('show');

Route::post('/edit', 'ProjectsController@edit');

Route::delete('/project/{pID}', 'ProjectsController@delete');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::post('/allow', 'AllowsController@create');

Route::delete('/allow/{pID}', 'AllowsController@delete');

Route::post('/tag', 'TagController@store');

Route::get('addProject', function () {
    return view('addProject');
});

Route::get('/show/settings/{pID}', 'SettingsController@show');

Route::get('/show/contributors/{id}', 'ContributorsController@show');


