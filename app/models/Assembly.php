<?php

namespace T4KModels;

/**
 * T4KModels\Assembly class
 * @author      minhnhatbui
 * @copyright   2014 Équipe Team 3990: Tech for Kids (Collège Regina Assumpta, Montréal, QC)
 * @abstract    Model Controller managing assemblies.
 */

class Assembly extends \Eloquent
{
    
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 't4kprt_assemblies';
    
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
    		'desc'				=> 'required',
    		'code'				=> 'required|max:1|alpha'
    );
    
    /**
     * The set of messages thrown after rules validation.
     * @var array
     */
    public static $messages = array(
        	'title.required'    => 'Le nom de l\'assemblage est requis.',
    		'desc.required'		=> 'La description de l\'assemblage est requise.',
    		'code.required'		=> 'Le code de l\'assemblage est requis.',
    		'code.max'			=> 'Le code de l\'assemblage doit être une seule lettre aphabétique.',
    		'code.alpha'		=> 'Le code de l\'assemblage doit être une lettre aphabétique, excluant les lettres I et O.'
    );
    
    /**
     * Relationship to Project model.
     * @return Eloquent Relationship
     */
    public function project()
    {
    	return $this->belongsTo('\T4KModels\Project');
    }
    
    /**
     * Relationship to User model.
     * @return Eloquent Relationship
     */
    public function manager()
    {
    	return $this->belongsTo('\T4KModels\User', 'manager_id', 'id');
    }
    
}