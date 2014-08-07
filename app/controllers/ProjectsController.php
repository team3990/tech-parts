<?php

namespace T4KControllers\Projects;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

/**
 * T4KControllers\Dashboard\DashboardController class
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
                'currentRoute'      => \Route::currentRouteName(),
                'activeScreen'      => 'ProjectsIndex' 
	    );
	    
	    // Render view
	    $this->layout->content = \View::make('projects.index', $data);
	}

}
