<?php

namespace T4KControllers\Assemblies;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

/**
 * T4KControllers\Assemblies\AssembliesController class
 * @author 		minhnhatbui
 * @copyright 	2014 Équipe Team 3990: Tech for Kids (Collège Regina Assumpta, Montréal, QC)
 * @abstract 	View Controller managing assemblies with the Assembly model.
 */

class AssembliesController extends \BaseController { 
    
    /**
     * Constructor.
     */
    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth');
        setlocale(LC_ALL, 'fr_CA.UTF-8');
    }
    
    /**
     * Display all assemblies.
     * @return View Response
     */
	public function index()
	{	    
		// Retrieve all projets
		$assemblies = \T4KModels\Assembly::orderBy('code')->orderBy('title')->get();
		
	    // Array of data to send to view
	    $data = array(
	    		'assemblies'		=> $assemblies,
	    		'ItemsCount'    	=> count($assemblies),
                'currentRoute'      => Route::currentRouteName(),
                'activeScreen'      => 'AssembliesIndex' 
	    );
	    
	    // Render view
	    $this->layout->content = View::make('assemblies.index', $data);
	}
	
	/**
	 * View an assembly.
	 * @param int $id
	 */
	public function view($id)
	{
		// Retrieve an assembly with its id
		$assembly = \T4KModels\Assembly::find($id);
	
		// Array of data to send to view
		$data = array(
				'assembly'       	=> $assembly,
				'currentRoute'  	=> Route::currentRouteName(),
				'activeScreen'  	=> 'AssembliesIndex'
		);
	
		// Render view
		$this->layout->content = View::make('assemblies.index', $data);
	}
	
	/**
	 * Create an assembly.
	 * @return View Response
	 */
	public function create($id)
	{
		// Retrieve current project
		$project = \T4KModels\Project::find($id);
		
		// Retrieve all managers
		$managers = \T4KModels\User::orderBy('last_name')->orderBy('first_name')->get();
		
		// Array of data to send to view
		$data = array(
				'project'			=> $project,
				'managers'			=> $managers,
				'currentRoute'  	=> Route::currentRouteName(),
				'activeScreen'  	=> 'AssembliesIndex'
		);
	
		// Render view
		$this->layout->content = View::make('assemblies.form', $data);
	}
	
	/**
	 * Store the new assembly into DB.
	 * @return Response
	 */
	public function store()
	{
		// Validation rules
		$validator = Validator::make(Input::all(), \T4KModels\Assembly::$rules, \T4KModels\Assembly::$messages);
	
		// Validator check
		if ($validator->fails())
		{
			// Throw error and redirect to previous screen
			return Redirect::route('parts.assemblies.create', Input::get('project_id'))->withErrors($validator)->withInput();
		}
		else
		{
			// Create new object from model and save it
			$assembly = new \T4KModels\Assembly;
			$assembly->title		= Input::get('title');
			$assembly->desc      	= Input::get('desc');
			$assembly->code			= Input::get('code');
			$assembly->manager_id	= Input::get('manager_id');
			$assembly->project_id	= Input::get('project_id');
			$assembly->save();
	
			// Redirect to view screen with success message
			Session::flash('store', true);
			return Redirect::route('parts.assemblies.view', $assembly->id);
		}
	}
	
	/**
	 * Modify an existing assembly.
	 * @param int $id
	 * @return View Response
	 */
	public function edit($id)
	{
		// Retrieve the assembly with its id
		$assembly = \T4KModels\Assembly::find($id);
		
		// Retrieve current project
		$project = $assembly->project;
		
		// Retrieve all managers
		$managers = \T4KModels\User::orderBy('last_name')->orderBy('first_name')->get();
	
		// Array of data to send to view
		$data = array(
				'assembly'       	=> $assembly,
				'project'			=> $project,
				'managers'			=> $managers,
				'currentRoute'  	=> Route::currentRouteName(),
				'activeScreen'  	=> 'AssembliesIndex'
		);
	
		// Render view
		$this->layout->content = \View::make('assemblies.form', $data);
	}
	
	/**
	 * Post the updated assembly to the DB.
	 * @param int $id
	 * @return Response
	 */
	public function update($id)
	{
		// Validation rules
		$validator = Validator::make(Input::all(), \T4KModels\Assembly::$rules, \T4KModels\Assembly::$messages);
	
		// Validator check
		if ($validator->fails())
		{
			// Throw error and redirect to previous screen
			return Redirect::route('parts.assemblies.edit', $id)->withErrors($validator)->withInput();
		}
		else
		{
			// Retrieve object from model and update it
			$assembly = \T4KModels\Assembly::find($id);
			$assembly->title		= Input::get('title');
			$assembly->desc      	= Input::get('desc');
			$assembly->code			= Input::get('code');
			$assembly->manager_id	= Input::get('manager_id');
			$assembly->project_id	= Input::get('project_id');
			$assembly->save();
				
			// Redirect to view screen with success message
			Session::flash('update', true);
			return Redirect::route('parts.assemblies.view', $assembly->id);
		}
	}
	
	/**
	 * Soft destroy an assembly.
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Retrieve object
		$assembly = \T4KModels\Assembly::where('id', $id)->first();
		Session::flash('object_name', $assembly->title);
		$project_id = $assembly->project->id;
		 
		// Delete object
		$assembly->delete();
	
		// Redirect to view screen with success message
		Session::flash('destroy', true);
		return Redirect::route('parts.projects.view', $project_id);
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
				'activeScreen'  	=> 'AssembliesIndex'
		);
		 
		// Redirect to Dashboard
		return Redirect::route('parts.projects.index', $data);
	}

}
