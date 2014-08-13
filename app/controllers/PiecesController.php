<?php

namespace T4KControllers\Pieces;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

/**
 * T4KControllers\Pieces\PiecesController class
 * @author 		minhnhatbui
 * @copyright 	2014 Équipe Team 3990: Tech for Kids (Collège Regina Assumpta, Montréal, QC)
 * @abstract 	View Controller managing assemblies with the Piece model.
 */

class PiecesController extends \BaseController { 
	
	/**
	 * File upload path
	 * @var string
	 */
	protected $upload_path = '/files/pieces/';
    
    /**
     * Constructor.
     */
    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth');
        setlocale(LC_ALL, 'fr_CA.UTF-8');
        $this->upload_path = public_path().$this->upload_path;
    }
    
    /**
     * Display all pieces.
     * @return View Response
     */
	public function index()
	{	    
		// Retrieve all subassemblies
		$pieces = \T4KModels\Piece::orderBy('code')->orderBy('title')->get();
		
	    // Array of data to send to view
	    $data = array(
	    		'pieces'			=> $pieces,
	    		'ItemsCount'    	=> count($pieces),
                'currentRoute'      => Route::currentRouteName(),
                'activeScreen'      => 'PiecesIndex' 
	    );
	    
	    // Render view
	    $this->layout->content = View::make('pieces.index', $data);
	}
	
	/**
	 * View a piece.
	 * @param int $id
	 */
	public function view($id)
	{
		// Retrieve a piece with its id
		$piece = \T4KModels\Piece::find($id);
		
		// Retrieve current subassembly
		$subassembly = $piece->subassembly;
	
		// Array of data to send to view
		$data = array(
				'piece'       		=> $piece,
				'subassembly'		=> $subassembly,
				'currentRoute'  	=> Route::currentRouteName(),
				'activeScreen'  	=> 'PiecesIndex'
		);
	
		// Render view
		$this->layout->content = View::make('pieces.index', $data);
	}
	
	/**
	 * Create a piece.
	 * @return View Response
	 */
	public function create($sub_id, $type_id)
	{
		// Retrieve current subassembly
		$subassembly = \T4KModels\Subassembly::find($sub_id);
		
		// Retrieve current assembly
		$assembly = $subassembly->assembly;
		
		// Retrieve current project
		$project = $assembly->project;
		
		// Retrieve all users
		$users = \T4KModels\User::orderBy('last_name')->orderBy('first_name')->get();
		
		// Retrieve piece type
		$piece_type = \T4KModels\PieceType::find($type_id);
		
		// Retrieve providers
		$providers = \T4KModels\Provider::orderBy('title')->get();
		
		// Array of data to send to view
		$data = array(
				'project'			=> $project,
				'assembly'			=> $assembly,
				'subassembly'		=> $subassembly,
				'users'				=> $users,
				'piece_type'		=> $piece_type,
				'providers'			=> $providers,
				'currentRoute'  	=> Route::currentRouteName(),
				'activeScreen'  	=> 'PiecesIndex'
		);
	
		// Render view
		$this->layout->content = View::make('pieces.form', $data);
	}
	
	/**
	 * Store the new piece into DB.
	 * @return Response
	 */
	public function store($sub_id, $type_id)
	{
		// Validation rules
		$validator = Validator::make(Input::all(), \T4KModels\Piece::$rules, \T4KModels\Piece::$messages);
		
		// Uploaded files
		$file = (object) array(
				'invoice' 				=> Input::file('invoice'),
				'quote'					=> Input::file('quote'),
				'technical_drawing'		=> Input::file('technical_drawing')
		);
	
		// Validator check
		if ($validator->fails())
		{
			// Throw error and redirect to previous screen
			return Redirect::route('parts.pieces.create', array($sub_id, $type_id))->withErrors($validator)->withInput();
		}
		else
		{
			// Create new object from model and save it
			$piece = new \T4KModels\Piece;
			$piece->subassembly_id		= Input::get('subassembly_id');
			$piece->piece_type_id		= Input::get('piece_type_id');
			$piece->author_id			= Input::get('author_id');
			if (!is_scalar(Input::get('provider_id')))
			{
				$provider = new \T4KModels\Provider;
				$provider->title = Input::get('provider_id');
				$provider->save();
				$piece->provider_id = $provider->id;
			}
			else
			{
				$piece->provider_id = Input::get('provider_id');
			}
			$piece->datetime_due		= Input::get('datetime_due');
			$piece->datetime_tosend		= Input::get('datetime_tosend');
			$piece->datetime_sent		= Input::get('datetime_sent');
			$piece->datetime_toreceive	= Input::get('datetime_toreceive');
			$piece->datetime_received	= Input::get('datetime_received');
			$piece->datetime_toorder	= Input::get('datetime_toorder');
			$piece->datetime_ordered	= Input::get('datetime_ordered');
			$piece->title				= Input::get('title');
			$piece->desc      			= Input::get('desc');
			$piece->code				= Input::get('code');
			$piece->material 			= Input::get('material');
			$piece->unit_price			= Input::get('unit_price');
			$piece->quantity			= Input::get('quantity');
			$piece->invoice				= (!empty($file->invoice)) ? $file->invoice->getClientOriginalName() : $piece->invoice;
			$piece->quote				= (!empty($file->quote)) ? $file->quote->getClientOriginalName() : $piece->quote;
			$piece->external_link		= Input::get('external_link');
			$piece->technical_drawing	= (!empty($file->technical_drawing)) ? $file->technical_drawing->getClientOriginalName() : $piece->technical_drawing;
			$piece->save();
			
			// File upload
			if (!empty($file->invoice)) 			$file->invoice->move($this->upload_path.$piece->id.'/', $file->invoice->getClientOriginalName());
			if (!empty($file->quote)) 				$file->quote->move($this->upload_path.$piece->id.'/', $file->quote->getClientOriginalName());
			if (!empty($file->technical_drawing)) 	$file->technical_drawing->move($this->upload_path.$piece->id.'/', $file->technical_drawing->getClientOriginalName());
	
			// Redirect to view screen with success message
			Session::flash('store', true);
			return Redirect::route('parts.pieces.view', $piece->id);
		}
	}
	
	/**
	 * Modify an existing piece.
	 * @param int $id
	 * @return View Response
	 */
	public function edit($id)
	{
		// Retrieve the piece with its id
		$piece = \T4KModels\Piece::find($id);
		
		// Retrieve current subassembly;
		$subassembly = $piece->subassembly;
		
		// Retrieve current assembly
		$assembly = $subassembly->assembly;
		
		// Retrieve current project
		$project = $assembly->project;
		
		// Retrieve all users
		$users = \T4KModels\User::orderBy('last_name')->orderBy('first_name')->get();
		
		// Retrieve piece type
		$piece_type = \T4KModels\PieceType::find($piece->type->id);
		
		// Retrieve providers
		$providers = \T4KModels\Provider::orderBy('title')->get();
	
		// Array of data to send to view
		$data = array(
				'piece'				=> $piece,
				'subassembly'		=> $subassembly,
				'assembly'       	=> $assembly,
				'project'			=> $project,
				'users'				=> $users,
				'piece_type'		=> $piece_type,
				'providers'			=> $providers,
				'currentRoute'  	=> Route::currentRouteName(),
				'activeScreen'  	=> 'PiecesIndex'
		);
	
		// Render view
		$this->layout->content = \View::make('pieces.form', $data);
	}
	
	/**
	 * Post the updated piece to the DB.
	 * @param int $id
	 * @return Response
	 */
	public function update($id)
	{
		// Validation rules
		$validator = Validator::make(Input::all(), \T4KModels\Piece::$rules, \T4KModels\Piece::$messages);
		
		// Uploaded files
		$file = (object) array(
				'invoice' 				=> Input::file('invoice'),
				'quote'					=> Input::file('quote'),
				'technical_drawing'		=> Input::file('technical_drawing')
		);
	
		// Validator check
		if ($validator->fails())
		{
			// Throw error and redirect to previous screen
			return Redirect::route('parts.pieces.edit', array($id, Input::get('piece_type_id')))->withErrors($validator)->withInput();
		}
		else
		{
			// Retrieve object from model and update it
			$piece = \T4KModels\Piece::find($id);
			$piece->subassembly_id		= Input::get('subassembly_id');
			$piece->piece_type_id		= Input::get('piece_type_id');
			$piece->author_id			= Input::get('author_id');
			if (!is_scalar(Input::get('provider_id')))
			{
				$provider = new \T4KModels\Provider;
				$provider->title = Input::get('provider_id');
				$provider->save();
				$piece->provider_id = $provider->id;
			}
			else
			{
				$piece->provider_id = Input::get('provider_id');
			}
			$piece->datetime_due		= Input::get('datetime_due');
			$piece->datetime_tosend		= Input::get('datetime_tosend');
			$piece->datetime_sent		= Input::get('datetime_sent');
			$piece->datetime_toreceive	= Input::get('datetime_toreceive');
			$piece->datetime_received	= Input::get('datetime_received');
			$piece->datetime_toorder	= Input::get('datetime_toorder');
			$piece->datetime_ordered	= Input::get('datetime_ordered');
			$piece->title				= Input::get('title');
			$piece->desc      			= Input::get('desc');
			$piece->code				= Input::get('code');
			$piece->material 			= Input::get('material');
			$piece->unit_price			= Input::get('unit_price');
			$piece->quantity			= Input::get('quantity');
			$piece->invoice				= (!empty($file->invoice)) ? $file->invoice->getClientOriginalName() : $piece->invoice;
			$piece->quote				= (!empty($file->quote)) ? $file->quote->getClientOriginalName() : $piece->quote;
			$piece->external_link		= Input::get('external_link');
			$piece->technical_drawing	= (!empty($file->technical_drawing)) ? $file->technical_drawing->getClientOriginalName() : $piece->technical_drawing;
			$piece->save();
			
			// File upload
			if (!empty($file->invoice)) 			$file->invoice->move($this->upload_path.$piece->id.'/', $file->invoice->getClientOriginalName());
			if (!empty($file->quote)) 				$file->quote->move($this->upload_path.$piece->id.'/', $file->quote->getClientOriginalName());
			if (!empty($file->technical_drawing)) 	$file->technical_drawing->move($this->upload_path.$piece->id.'/', $file->technical_drawing->getClientOriginalName());

			// Redirect to view screen with success message
			Session::flash('update', true);
			return Redirect::route('parts.pieces.view', $piece->id);
		}
	}
	
	/**
	 * Soft destroy a piece.
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Retrieve object
		$piece = \T4KModels\Piece::where('id', $id)->first();
		Session::flash('object_name', $piece->title);
		$subassembly_id = $piece->subassembly_id;
		 
		// Delete object
		$piece->delete();
	
		// Redirect to view screen with success message
		Session::flash('destroy', true);
		return Redirect::route('parts.subassemblies.view', $subassembly_id);
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
