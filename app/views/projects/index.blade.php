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
                    <div class="page-header">
                        <h1><i class="fa fa-briefcase fa-fw"></i> Projets <small>Tous les projets</small></h1>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12">
                    <div class="btn-toolbar" role="toolbar">
                    
                        <?php if (Auth::user()->is_admin) : ?>
                        <div class="btn-group">
                            <a href="<?php echo route('parts.projects.create'); ?>" class="btn btn-default"><i class="fa fa-plus fa-fw"></i> Ajouter un projet</a>
                        </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
            
            <div class="row">
            	<div class="col-xs-12">
            		<table class="table table-hover">
            			<thead>
            				<tr>
            					<th>Nom</th>
            					<th>Description</th>
            					<th>Actions</th>
            				</tr>
            			</thead>
            			<tbody>
            				<?php foreach ($projects as $project) : ?>
            				<tr>
            					<td><?php echo $project->title; ?></td>
            					<td><?php echo $project->desc; ?></td>
            					<td>
            						<a href="<?php echo route('parts.projects.edit'); ?>" class="btn btn-sm"><i class="fa fa-pencil fa-fw"></i></a>
            					</td>
            				</tr>
            				<?php endforeach; ?>
            			</tbody>
            		</table>
            		<?php if (count($projects) == 0) : ?>
            			<div class="alert alert-warning text-center">Aucun projet disponible pour le moment.</div>
					<?php endif; ?>
            	</div>
            </div>
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
