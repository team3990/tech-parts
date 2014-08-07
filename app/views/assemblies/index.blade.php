@extends('layout.master') 

    @section('head')
        
        @parent
        
        {{-- HTML Header Section --}}
        @section('title')
            Projets
        @stop
        
        @section('stylesheets')
            @parent
        @stop
        
        @section('scripts_header')
            @parent
        @stop
        
    @stop

    {{-- HTML Body Section --}}
    @section('body')
    
        @parent
    
        @section('content')
            <div class="row">
                <div class="col-xs-12">
                
                	<ol class="breadcrumb">
						<li><a href="<?php echo route('parts.projects.index'); ?>">Projets</a></li>
						<li><a href="<?php echo route('parts.projects.view', $assembly->project->id); ?>"><i class="fa fa-briefcase fa-fw"></i> <?php echo $assembly->project->title; ?></a></li>
						<li class="active"><i class="fa fa-cubes fa-fw"></i> <?php echo $assembly->title; ?></li>
					</ol>
					
                    <div class="page-header">
                        <h1><i class="fa fa-cubes fa-fw"></i> Assemblage <small><?php echo ($currentRoute == 'parts.assemblies.view') ? 'Voir un assemblage' : 'Tous les assemblages'; ?></small></h1>
                    </div>
                    
                </div>
            </div>
            
            <?php if ($currentRoute == 'parts.assemblies.view') : ?>

            	
            <?php else : ?>
	            
            <?php endif; ?>
        @stop
        
    @stop
    
    @section('footer')
        
        @parent 
        
        @section('footer-content')
            @parent
        @stop
    
        @section('scripts_eof')
            @parent            
        @stop
        
    @stop
