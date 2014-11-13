<?php

namespace T4KModels;

/**
 * T4KModels\PieceType class
 * @author      minhnhatbui
 * @copyright   2014 Équipe Team 3990: Tech for Kids (Collège Regina Assumpta, Montréal, QC)
 * @abstract    Model Controller managing parts processes.
 */

class PieceProcess extends \Eloquent
{
    
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 't4kprt_piece_process';
    
    /**
     * Enable model soft deleting functionality.
     */
    use \SoftDeletingTrait;
    
    /**
     * Relationship to Piece model.
     * @return Eloquent Relationship
     */
    public function piece()
    {
    	return $this->belongsTo('\T4KModels\Piece', 'piece_id', 'id');
    }
    
    /**
     * Relationship to Process model.
     * @return Eloquent Relationship
     */
    public function process()
    {
    	return $this->belongsTo('\T4KModels\Process', 'process_id', 'id');
    }
    
    /**
     * Relationship to Status model.
     * @return Eloquent Relationship
     */
    public function status()
    {
    	return $this->belongsTo('\T4KModels\Status', 'status_id', 'id');
    }
    
    /**
     * Relationship to User model.
     * @return Eloquent Relationship
     */
    public function user()
    {
    	return $this->belongsTo('\T4KModels\User', 'user_id', 'id');
    }
    
}