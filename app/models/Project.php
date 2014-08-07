<?php

namespace T4KModels;

/**
 * T4KModels\Project class
 * @author      minhnhatbui
 * @copyright   2014 Équipe Team 3990: Tech for Kids (Collège Regina Assumpta, Montréal, QC)
 * @abstract    Model Controller managing projects.
 */

class Project extends \Eloquent
{
    
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 't4kprt_projects';
    
    /**
     * Enable model soft deleting functionality.
     */
    use \SoftDeletingTrait;
    
    /**
     * The set of rules to be validated when creating the initial administrator account.
     * @var array
     */
    public static $rules = array(
        	'title'             => 'required',
    		'desc'				=> 'required'
    );
    
    /**
     * The set of messages thrown after rules validation.
     * @var array
     */
    public static $messages = array(
        	'title.required'    => 'Le nom du projet est requis.',
    		'desc.required'		=> 'La description du projet est requise.'
    );
    
    /**
     * Relationship to Assembly model.
     * @return Eloquent Relationship
     */
    public function assemblies()
    {
    	return $this->hasMany('\T4KModels\Assembly')->orderBy('code')->orderBy('title');
    }
    
}