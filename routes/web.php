<?php

use App\Project;
use Illuminate\Http\Request;

Auth::routes();

Route::get('/', 'ProjectsController@projects');

Route::post('/project', 'ProjectsController@create');

Route::get('/show/{id}', 'ProjectsController@show')->name('show');

Route::post('/edit', 'ProjectsController@edit');

Route::delete('/project/{pID}', 'ProjectsController@delete');

Route::get('/home', 'HomeController@index');

Route::post('/allow', 'Project_and_contributorsController@create');

Route::delete('/allow/{pID}', 'Project_and_contributorsController@delete');

Route::post('/tag', 'TagController@store');

Route::get('addProject', function () { return view('addProject'); });

Route::get('/show/settings/{pID}', 'SettingsController@show');

Route::get('/show/contributors/{id}', 'ContributorsController@show');

Route::get('/show/wiki/{id}/{wTitle}', 'WikisController@show')->name('showWiki');

Route::get('profile/{id}', 'ProfileController@show');

Route::get('/editProfilePage/{id}', 'ProfileController@show_for_edit');

Route::post('/updateProfile', 'UsersController@update');

Route::post('/updateEmployment', 'EmploymentController@create');

Route::post('/updateEducation', 'EducationController@create');

Route::get('/deleteEmployment/{id}', 'EmploymentController@delete');

Route::get('/deleteEducation/{id}', 'EducationController@delete');

Route::post('AjaxPage', 'UsersController@search');

Route::post('addRightCol', 'UsersController@addRightCol');

Route::get('download/{filename}', 'FileController@download');

Route::post('changePermission', 'ContributorsController@edit');

Route::post('uploadFile', 'FileController@upload');

Route::get('test', function(){
	return view('test');
});

Route::post('invest', 'InvestmentsController@create');

Route::post('editWiki', 'WikisController@edit');

Route::post('addWiki', 'WikisController@add');

Route::post('/saveTags', 'TagController@add');