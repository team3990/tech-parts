<?php

namespace T4KModels;

/**
 * T4KModels\PieceType class
 * @author      minhnhatbui
 * @copyright   2014 Équipe Team 3990: Tech for Kids (Collège Regina Assumpta, Montréal, QC)
 * @abstract    Model Controller managing parts types.
 */

class PieceType extends \Eloquent
{
    
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 't4kprt_piece_type';
    
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
    	return $this->hasMany('\T4KModels\Piece', 'piece_type_id', 'id');
    }
    
}