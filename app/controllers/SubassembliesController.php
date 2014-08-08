<?php

namespace T4KControllers\Subassemblies;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

/**
 * T4KControllers\Subassemblies\SubassembliesController class
 * @author 		minhnhatbui
 * @copyright 	2014 Équipe Team 3990: Tech for Kids (Collège Regina Assumpta, Montréal, QC)
 * @abstract 	View Controller managing assemblies with the Subassembly model.
 */

class SubassembliesController extends \BaseController { 
    
    /**
     * Constructor.
     */
    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth');
        setlocale(LC_ALL, 'fr_CA.UTF-8');
    }
    
    /**
     * Display all subassemblies.
     * @return View Response
     */
	public function index()
	{	    
		// Retrieve all subassemblies
		$subassemblies = \T4KModels\Subassembly::orderBy('code')->orderBy('title')->get();
		
	    // Array of data to send to view
	    $data = array(
	    		'subassemblies'		=> $subassemblies,
	    		'ItemsCount'    	=> count($subassemblies),
                'currentRoute'      => Route::currentRouteName(),
                'activeScreen'      => 'SubassembliesIndex' 
	    );
	    
	    // Render view
	    $this->layout->content = View::make('subassemblies.index', $data);
	}
	
	/**
	 * View an subassembly.
	 * @param int $id
	 */
	public function view($id)
	{
		// Retrieve a subassembly with its id
		$subassembly = \T4KModels\Subassembly::find($id);
	
		// Array of data to send to view
		$data = array(
				'subassembly'       => $subassembly,
				'currentRoute'  	=> Route::currentRouteName(),
				'activeScreen'  	=> 'SubassembliesIndex'
		);
	
		// Render view
		$this->layout->content = View::make('subassemblies.index', $data);
	}
	
	/**
	 * Create a subassembly.
	 * @return View Response
	 */
	public function create($id)
	{
		// Retrieve current assembly
		$assembly = \T4KModels\Assembly::find($id);
		
		// Retrieve current project
		$project = $assembly->project;
		
		// Retrieve all managers
		$managers = \T4KModels\User::orderBy('last_name')->orderBy('first_name')->get();
		
		// Array of data to send to view
		$data = array(
				'project'			=> $project,
				'assembly'			=> $assembly,
				'managers'			=> $managers,
				'currentRoute'  	=> Route::currentRouteName(),
				'activeScreen'  	=> 'SubassembliesIndex'
		);
	
		// Render view
		$this->layout->content = View::make('subassemblies.form', $data);
	}
	
	/**
	 * Store the new subassembly into DB.
	 * @return Response
	 */
	public function store()
	{
		// Validation rules
		$validator = Validator::make(Input::all(), \T4KModels\Subassembly::$rules, \T4KModels\Subassembly::$messages);
	
		// Validator check
		if ($validator->fails())
		{
			// Throw error and redirect to previous screen
			return Redirect::route('parts.subassemblies.create', Input::get('assembly_id'))->withErrors($validator)->withInput();
		}
		else
		{
			// Create new object from model and save it
			$subassembly = new \T4KModels\Subassembly();
			$subassembly->title			= Input::get('title');
			$subassembly->desc      	= Input::get('desc');
			$subassembly->code			= Input::get('code');
			$subassembly->assembly_id	= Input::get('assembly_id');
			$subassembly->save();
	
			// Redirect to view screen with success message
			Session::flash('store', true);
			return Redirect::route('parts.subassemblies.view', $subassembly->id);
		}
	}
	
	/**
	 * Modify an existing subassembly.
	 * @param int $id
	 * @return View Response
	 */
	public function edit($id)
	{
		// Retrieve the subassembly with its id
		$subassembly = \T4KModels\Subassembly::find($id);
		
		// Retrieve current assembly
		$assembly = $subassembly->assembly;
		
		// Retrieve current project
		$project = $assembly->project;
		
		// Retrieve all managers
		$managers = \T4KModels\User::orderBy('last_name')->orderBy('first_name')->get();
	
		// Array of data to send to view
		$data = array(
				'subassembly'		=> $subassembly,
				'assembly'       	=> $assembly,
				'project'			=> $project,
				'managers'			=> $managers,
				'currentRoute'  	=> Route::currentRouteName(),
				'activeScreen'  	=> 'SubassembliesIndex'
		);
	
		// Render view
		$this->layout->content = \View::make('subassemblies.form', $data);
	}
	
	/**
	 * Post the updated subassembly to the DB.
	 * @param int $id
	 * @return Response
	 */
	public function update($id)
	{
		// Validation rules
		$validator = Validator::make(Input::all(), \T4KModels\Subassembly::$rules, \T4KModels\Subassembly::$messages);
	
		// Validator check
		if ($validator->fails())
		{
			// Throw error and redirect to previous screen
			return Redirect::route('parts.subassemblies.edit', $id)->withErrors($validator)->withInput();
		}
		else
		{
			// Retrieve object from model and update it
			$subassembly = \T4KModels\Subassembly::find($id);
			$subassembly->title			= Input::get('title');
			$subassembly->desc      	= Input::get('desc');
			$subassembly->code			= Input::get('code');
			$subassembly->save();
							
			// Redirect to view screen with success message
			Session::flash('update', true);
			return Redirect::route('parts.subassemblies.view', $subassembly->id);
		}
	}
	
	/**
	 * Soft destroy a subassembly.
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Retrieve object
		$subassembly = \T4KModels\Subassembly::where('id', $id)->first();
		Session::flash('object_name', $subassembly->title);
		$assembly_id = $subassembly->assembly_id;
		 
		// Delete object
		$subassembly->delete();
	
		// Redirect to view screen with success message
		Session::flash('destroy', true);
		return Redirect::route('parts.assemblies.view', $assembly_id);
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
