<?php

namespace T4KModels;

/**
 * T4KModels\Status class
 * @author      minhnhatbui
 * @copyright   2014 Équipe Team 3990: Tech for Kids (Collège Regina Assumpta, Montréal, QC)
 * @abstract    Model Controller managing parts status.
 */

class Status extends \Eloquent
{
    
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 't4kprt_status';
    
    /**
     * Enable model soft deleting functionality.
     */
    use \SoftDeletingTrait;
        
}