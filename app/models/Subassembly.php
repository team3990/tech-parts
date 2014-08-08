<?php

namespace T4KModels;

/**
 * T4KModels\Subassembly class
 * @author      minhnhatbui
 * @copyright   2014 Équipe Team 3990: Tech for Kids (Collège Regina Assumpta, Montréal, QC)
 * @abstract    Model Controller managing subassemblies.
 */

class Subassembly extends \Eloquent
{
    
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 't4kprt_subassemblies';
    
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
    		'code'				=> 'required|max:2|digits:2'
    );
    
    /**
     * The set of messages thrown after rules validation.
     * @var array
     */
    public static $messages = array(
        	'title.required'    => 'Le nom du sous-assemblage est requis.',
    		'desc.required'		=> 'La description du sous-assemblage est requise.',
    		'code.required'		=> 'Le code du sous-assemblage est requis.',
    		'code.digits'		=> 'Le code du sous-assemblage doit être composé uniquement de caractères numériques.',
    		'code.max'			=> 'Le code du sous-assemblage doit être composé de deux chiffres entre 01 et 99.'
    );
    
    /**
     * Relationship to Project model.
     * @return Eloquent Relationship
     */
    public function assembly()
    {
    	return $this->belongsTo('\T4KModels\Assembly');
    }
    
    /**
     * Relationship to Part model.
     * @return Eloquent Relationship
     */
    public function pieces()
    {
    	return $this->hasMany('\T4KModels\Piece')->orderBy('code')->orderBy('title');
    }
    
    /**
     * Attribute: nomenclature
     * @return string
     */
    public function getNomenclatureAttribute()
    {
    	return 'CRA-'.$this->assembly->code.$this->code.'00';
    }
    
}