<?php

namespace T4KControllers\Projects;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

/**
 * T4KControllers\Projects\ProjectsController class
 * @author 		minhnhatbui
 * @copyright 	2014 Équipe Team 3990: Tech for Kids (Collège Regina Assumpta, Montréal, QC)
 * @abstract 	View Controller managing projects with the Project model.
 */

class ProjectsController extends \BaseController { 
    
    /**
     * Constructor.
     */
    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth');
        setlocale(LC_ALL, 'fr_CA.UTF-8');
    }
    
    /**
     * Display all projects.
     * @return View Response
     */
	public function index()
	{	    
		// Retrieve all projets
		$projects = \T4KModels\Project::orderBy('title')->get();
		
	    // Array of data to send to view
	    $data = array(
	    		'projects'			=> $projects,
	    		'ItemsCount'    	=> count($projects),
                'currentRoute'      => Route::currentRouteName(),
                'activeScreen'      => 'ProjectsIndex' 
	    );
	    
	    // Render view
	    $this->layout->content = View::make('projects.index', $data);
	}
	
	/**
	 * View a project.
	 * @param int $id
	 */
	public function view($id)
	{
		// Retrieve a project with its id
		$project = \T4KModels\Project::find($id);
	
		// Array of data to send to view
		$data = array(
				'project'       	=> $project,
				'currentRoute'  	=> Route::currentRouteName(),
				'activeScreen'  	=> 'ProjectsIndex'
		);
	
		// Render view
		$this->layout->content = View::make('projects.index', $data);
	}
	
	/**
	 * Create a project.
	 * @return View Response
	 */
	public function create()
	{
		// Array of data to send to view
		$data = array(
				'currentRoute'  	=> Route::currentRouteName(),
				'activeScreen'  	=> 'ProjectsIndex'
		);
	
		// Render view
		$this->layout->content = View::make('projects.form', $data);
	}
	
	/**
	 * Store the new project into DB.
	 * @return Response
	 */
	public function store()
	{
		// Validation rules
		$validator = Validator::make(Input::all(), \T4KModels\Project::$rules, \T4KModels\Project::$messages);
	
		// Validator check
		if ($validator->fails())
		{
			// Throw error and redirect to previous screen
			return Redirect::route('parts.projects.create')->withErrors($validator)->withInput();
		}
		else
		{
			// Create new object from model and save it
			$project = new \T4KModels\Project;
			$project->title			= Input::get('title');
			$project->desc      	= Input::get('desc');
			$project->save();
	
			// Redirect to view screen with success message
			Session::flash('store', true);
			return Redirect::route('parts.projects.view', $project->id);
		}
	}
	
	/**
	 * Modify an existing project.
	 * @param int $id
	 * @return View Response
	 */
	public function edit($id)
	{
		// Retrieve the project with its id
		$project = \T4KModels\Project::find($id);
	
		// Array of data to send to view
		$data = array(
				'project'       	=> $project,
				'currentRoute'  	=> Route::currentRouteName(),
				'activeScreen'  	=> 'ProjectsIndex'
		);
	
		// Render view
		$this->layout->content = \View::make('projects.form', $data);
	}
	
	/**
	 * Post the updated project to the DB.
	 * @param int $id
	 * @return Response
	 */
	public function update($id)
	{
		// Validation rules
		$validator = Validator::make(Input::all(), \T4KModels\Project::$rules, \T4KModels\Project::$messages);
	
		// Validator check
		if ($validator->fails())
		{
			// Throw error and redirect to previous screen
			return Redirect::route('parts.projects.edit', $id)->withErrors($validator)->withInput();
		}
		else
		{
			// Retrieve object from model and update it
			$project = \T4KModels\Project::find($id);
			$project->title        	= Input::get('title');
			$project->desc      	= Input::get('desc');
			$project->save();
	
			// Redirect to view screen with success message
			Session::flash('update', true);
			return Redirect::route('parts.projects.view', $project->id);
		}
	}
	
	/**
	 * Soft destroy a project.
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Retrieve object
		$project = \T4KModels\Project::where('id', $id)->first();
		Session::flash('object_name', $project->title);
		 
		// Delete object
		$project->delete();
	
		// Redirect to view screen with success message
		Session::flash('destroy', true);
		return Redirect::route('parts.projects.index');
	}
	
	/**
	 * Catch-all method for handling missing methods.
	 * @return Redirect Response
	 */
	public function missingMethod($parameters = array())
	{
		// Array of data to send to view
		$data = array(
				'currentRoute'  	=> Route::currentRouteName(),
				'activeScreen'  	=> 'ProjectsIndex'
		);
		 
		// Redirect to Dashboard
		return Redirect::route('parts.projects.index', $data);
	}

}
