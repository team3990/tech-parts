<?php

namespace T4KModels;

/**
 * T4KModels\Provider class
 * @author      minhnhatbui
 * @copyright   2014 Équipe Team 3990: Tech for Kids (Collège Regina Assumpta, Montréal, QC)
 * @abstract    Model Controller managing providers.
 */

class Provider extends \Eloquent
{
    
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 't4kprt_providers';
    
    /**
     * Enable model soft deleting functionality.
     */
    use \SoftDeletingTrait;
    
    /**
     * Relationship to Piece model.
     * @return Eloquent Relationship
     */
    public function pieces()
    {
    	return $this->hasMany('\T4KModels\Piece', 'provider_id', 'id');
    }
        
}