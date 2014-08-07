<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * Module Users
 * @namespace T4KControllers\Users
 */
Route::group(array('prefix' => 'users'), function()
{
    // Login screen.
    Route::any('login',         	array('as' => 'parts.users.login',		'uses' => 'T4KControllers\Users\UsersController@login'));
    Route::any('connecting',    	array('as' => 'parts.users.connecting',	'uses' => 'T4KControllers\Users\UsersController@connecting'));

    // Logout screen.
    Route::any('logout',        	array('as' => 'parts.users.logout',		'uses' => 'T4KControllers\Users\UsersController@logout'));
});

Route::group(array('before' => 'auth'), function()
{
	/**
	 * Module Dashboard
	 * @namespace T4KControllers\Dashboard
	 */
	Route::any('/',             		array('as' => 'parts.dashboard.index',	'uses' => 'T4KControllers\Dashboard\DashboardController@index'));
	Route::any('dashboard',     		array('as' => 'parts.dashboard.index',	'uses' => 'T4KControllers\Dashboard\DashboardController@index'));
	
	/**
	 * Module Projects
	 * @namespace T4KControllers\Projects
	 */
	Route::group(array('prefix' => 'projets'), function()
	{
		Route::any('/',                     array('as' => 'parts.projects.index',		'uses' => 'T4KControllers\Projects\ProjectsController@index'));
		Route::any('afficher/{id}',         array('as' => 'parts.projects.view',      	'uses' => 'T4KControllers\Projects\ProjectsController@view'));
		Route::any('ajouter',               array('as' => 'parts.projects.create',    	'uses' => 'T4KControllers\Projects\ProjectsController@create'));
		Route::any('ajouter/save',          array('as' => 'parts.projects.store',     	'uses' => 'T4KControllers\Projects\ProjectsController@store'));
		Route::any('modifier/{id}',         array('as' => 'parts.projects.edit',      	'uses' => 'T4KControllers\Projects\ProjectsController@edit'));
		Route::any('modifier/save/{id}',    array('as' => 'parts.projects.update',    	'uses' => 'T4KControllers\Projects\ProjectsController@update'));
		Route::any('supprimer/{id}',        array('as' => 'parts.projects.destroy',   	'uses' => 'T4KControllers\Projects\ProjectsController@destroy'));
	});
	
	
});
