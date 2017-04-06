<?php
use App\Project;
use Illuminate\Http\Request;

Route::get('/', 'ProjectsController@projects');

Route::post('/project', 'ProjectsController@create');

Route::get('/show/{id}', 'ProjectsController@show')->name('show');

Route::post('/edit', 'ProjectsController@edit');

Route::delete('/project/{pID}', 'ProjectsController@delete');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::post('/allow', 'Project_and_contributorsController@create');

Route::delete('/allow/{pID}', 'Project_and_contributorsController@delete');

Route::post('/tag', 'TagController@store');

Route::get('addProject', function () {
    return view('addProject');
});

Route::get('/show/settings/{pID}', 'SettingsController@show');

Route::get('/show/contributors/{id}', 'ContributorsController@show');

Route::get('profile/{id}', 'ProfileController@show');

Route::get('/editProfilePage', function (){
	return view('editProfile');
})->name('editProfilePage');

Route::post('/updateProfile', 'UsersController@update');

Route::post('/updateEmployment', 'EmploymentController@create');

Route::post('/updateEducation', 'EducationController@create');
