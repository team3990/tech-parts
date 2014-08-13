<?php

namespace T4KModels;

/**
 * T4KModels\Piece class
 * @author      minhnhatbui
 * @copyright   2014 Équipe Team 3990: Tech for Kids (Collège Regina Assumpta, Montréal, QC)
 * @abstract    Model Controller managing parts.
 */

class Piece extends \Eloquent
{
    
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 't4kprt_pieces';
    
    /**
     * Enable model soft deleting functionality.
     */
    use \SoftDeletingTrait;
    
    /**
     * File upload path.
     * @var string
     */
    protected $upload_path = '/files/pieces/';
    
    /**
     * The set of rules to be validated when creating the initial administrator account.
     * @var array
     */
    public static $rules = array(
        	'title'             => 'required',
    		'desc'				=> 'required',
    		'code'				=> 'required|digits:2'
    );
    
    /**
     * The set of messages thrown after rules validation.
     * @var array
     */
    public static $messages = array(
        	'title.required'    => 'Le nom de l\'assemblage est requis.',
    		'desc.required'		=> 'La description de l\'assemblage est requise.',
    		'code.required'		=> 'Le code de l\'assemblage est requis.',
    		'code.digits'		=> 'Le code de l\'assemblage doit être composé de deux chiffres de 0 à 9.'
    );
    
    /**
     * Relationship to Project model.
     * @return Eloquent Relationship
     */
    public function subassembly()
    {
    	return $this->belongsTo('\T4KModels\Subassembly');
    }
    
    /**
     * Relationship to PieceType model.
     * @return Eloquent Relationship
     */
    public function type()
    {
    	return $this->belongsTo('\T4KModels\PieceType', 'piece_type_id', 'id');
    }
    
    /**
     * Relationship to User model.
     * @return Eloquent Relationship
     */
    public function author()
    {
    	return $this->belongsTo('\T4KModels\User', 'author_id', 'id');
    }
    
    /**
     * Relationship to Provider model.
     * @return Eloquent Relationship
     */
    public function provider()
    {
    	return $this->belongsTo('\T4KModels\Provider', 'provider_id', 'id');
    }
        
    /**
     * Attribute: nomenclature
     * @return string
     */
    public function getNomenclatureAttribute()
    {
    	return 'CRA-'.$this->subassembly->assembly->code.$this->subassembly->code.$this->code;
    }
    
    /**
     * Attribute: invoice file.
     * @return string
     */
    public function getInvoicePathAttribute()
    {
    	return $this->upload_path.$this->id.'/'.$this->invoice;
    }
    
    /**
     * Attribute: quote file.
     * @return string
     */
    public function getQuotePathAttribute()
    {
    	return $this->upload_path.$this->id.'/'.$this->quote;
    }
    
    /**
     * Attribute: technical drawing file.
     * @return string
     */
    public function getTechnicalDrawingPathAttribute()
    {
    	return $this->upload_path.$this->id.'/'.$this->technical_drawing;
    }
    
}